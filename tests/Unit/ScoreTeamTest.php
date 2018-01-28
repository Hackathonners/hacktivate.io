<?php

namespace Tests\Unit;

use Mockery as m;
use Tests\TestCase;
use App\Alexa\Models\Team;
use App\Alexa\Models\User;
use Faker\Factory as Faker;
use App\Alexa\Score\ScoreTeam;
use GrahamCampbell\GitHub\Facades\GitHub;

class ScoreTeamTest extends TestCase
{
    protected $faker;

    public function setUp()
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    public function testGetUserScore()
    {
        // Prepare
        $score = new ScoreTeam();
        $githubHandler = 'djcouto';
        $user = factory(User::class)->create([
          'github' => $githubHandler,
        ]);
        $userContributions = [
            'login' => $githubHandler,
            'contributions' => 10,
        ];
        $userOrganizations = [
          'login' => $githubHandler,
          'public_repos' => 10,
        ];
        $userGithubInfo = [
            'login' => $githubHandler,
            'public_repos' => 10,
            'public_gists' => 3,
            'followers' => 5,
        ];
        $team = factory(Team::class)->create();
        $team->users()->save($user);
        $repositories = $this->repositoriesFactory($githubHandler);
        foreach ($repositories as $repository) {
            $contributors = $this->contributorsFactory($userContributions);
        }
        $organizations = [];
        $this->mockGithubFacade($userGithubInfo, $organizations, $repositories, $contributors);
        $expectedScore = $this->calculateExpectedTeamScore($team, $userGithubInfo, collect($organizations), collect($repositories), collect($contributors));

        // Execute
        $actualScore = $score->getTeamScore($team);

        // Assert
        $this->assertEquals($expectedScore, $actualScore);
    }

    private function calculateExpectedTeamScore($team, $userInfo, $organizations, $repositories, $contributors)
    {
        // Get info about the user
        $publicRepos = $userInfo['public_repos'] * app('settings')->factor_number_repositories;
        $publicGists = $userInfo['public_gists'] * app('settings')->factor_gists;
        $followers = $userInfo['followers'] * app('settings')->factor_followers;

        // Get user ranking
        $total = $this->calculateUserScore($userInfo, $repositories, $contributors);

        // Get organizations ranking
        $total = $organizations->reduce(function ($carry, $item) use ($total) {
            return $carry + $this->calculateUserScore($item, $repositories, $contributors);
        }, $total);

        // Calculate final ranking
        $ranking = $total + $publicRepos + $publicGists;

        return $ranking;
    }

    private function calculateUserScore($user, $repositories, $contributors)
    {
        // Get info about the user
        $userName = $user['login'];
        $publicRepos = $user['public_repos'];
        $total = 0;

        // Get public repositories info
        if ($publicRepos > 0) {
            $total = $repositories->reduce(function ($carry, $item) use ($userName, $contributors) {

                // Calculate each parameter the with the respective factor
                $watchers = $item['watchers_count'] * app('settings')->factor_repository_watchers;
                $forks = $item['forks_count'] * app('settings')->factor_repository_forks;
                $size = $item['size'] * app('settings')->factor_repository_size;
                $stars = $item['stargazers_count'] * app('settings')->factor_repository_stars;

                $name = $item['name'];
                $owner = $item['owner']['login'];

                $contributions = $this->calculateRepositoryContributions($owner, $name, $userName, $contributors);
                $contributions *= app('settings')->factor_repository_contributions;

                return $carry + $watchers + $forks + $size + $stars + $contributions;
            }, 0);
        }

        return $total;
    }

    private function calculateRepositoryContributions(string $owner, string $name, string $user, $contributors)
    {
        $contributions = $contributors->reduce(function ($carry, $item) use ($user) {
            if ($item['login'] === $user) {
                return $carry + $item['contributions'];
            }

            return $carry;
        });

        return $contributions;
    }

    private function mockGithubFacade($user, $organizations, $repositories, $contributors)
    {
        $userName = $user['login'];

        Github::shouldReceive('user->show')
            ->once()
            ->with($userName)
            ->andReturn($user);

        Github::shouldReceive('user->organizations')
            ->once()
            ->with($userName)
            ->andReturn($organizations);

        Github::shouldReceive('user->repositories')
            ->with($userName)
            ->andReturn($repositories);

        Github::shouldReceive('repo->contributors')
            ->andReturn($contributors);
    }

    private function contributorsFactory($user, $contributorsNumber = 10)
    {
        $contributors = collect([$user]);
        for ($i = 0; $i < $contributorsNumber; $i++) {
            $contributors->push([
                'login' => $this->faker->unique()->name,
                'contributions' => $this->faker->numberBetween(10, 200),
            ]);
        }

        return $contributors;
    }

    private function repositoriesFactory($userName, $repositoriesNumber = 30)
    {
        $repositories = collect([]);
        for ($i = 0; $i < $repositoriesNumber; $i++) {
            $repositories->push([
                'forks_count' => 15,
                'watchers_count' => 10,
                'stargazers_count' => 10,
                'size' => 50,
                'name' => $this->faker->name,
                'owner' => [
                    'login' => $userName,
                ],
            ]);
        }

        return $repositories;
    }
}
