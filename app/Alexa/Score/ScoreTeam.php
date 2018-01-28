<?php

namespace App\Alexa\Score;

use Carbon\Carbon;
use App\Alexa\Models\Team;
use App\Alexa\Models\User;
use Illuminate\Support\Facades\Cache;

use GrahamCampbell\GitHub\Facades\GitHub;
use App\Exceptions\GithubHandlerException;

class ScoreTeam
{
    public function __construct()
    {
        //
    }

    /**
     * Get the score of this team.
     *
     * @param $useCache boolean
     * @param $team App\AlexaModels\Team;
     *
     * @return int
     */
    public function getTeamScore(Team $team, $useCache = true)
    {
        if ($useCache && Cache::has('team-'.$team->id)) {
            return Cache::get('team-'.$team->id);
        }

        $members = $team->users;
        $score = 0;

        foreach ($members as $member) {
            $score += $this->getUserScore($member, $useCache);
        }

        // Update cache
        $expiresAt = Carbon::today()->addDays(1);
        Cache::put('team-'.$team->id, $score, $expiresAt);

        return $score;
    }

    /**
     * Get the score of this team.
     *
     * @param $user App\Alexa\Models\User
     * @param $useCache boolean
     *
     * @return int
     */
    private function getUserScore(User $user, $useCache = true)
    {
        if ($useCache && Cache::has('user-'.$user->id)) {
            return Cache::get('user-'.$user->id);
        }

        // Get the github user
        $userInfo = GitHub::user()->show($user->github);

        // Check if the username exists
        throw_if(empty($userInfo), new GithubHandlerException($user->github, 'The invalid username given.'));

        // Get info about the user
        $publicRepos = $userInfo['public_repos'] * app('settings')->factor_number_repositories;
        $publicGists = $userInfo['public_gists'] * app('settings')->factor_gists;
        $followers = $userInfo['followers'] * app('settings')->factor_followers;

        // Get user score
        $total = $this->getGithubScore($userInfo);

        // Get organizations info
        $organizations = collect(GitHub::user()->organizations($user->github));

        // Get organizations score
        $total = $organizations->reduce(function ($carry, $item) use ($total) {
            return $carry + $this->getGithubScore($item);
        }, $total);

        // Calculate final score
        $score = $total + $publicRepos + $publicGists;

        // Update cache
        $expiresAt = Carbon::today()->addWeeks(1);
        Cache::put('user-'.$user->id, $score, $expiresAt);

        return $score;
    }

    /**
     * Get the github score of a given user.
     *
     * @param $user array
     *
     * @return int
     */
    private function getGithubScore($user)
    {
        // Get info about the user
        $userName = $user['login'];
        $publicRepos = $user['public_repos'];
        $total = 0;

        // Get public repositories info
        if ($publicRepos > 0) {

            // Get the user public repositories
            $repos = Github::user()->repositories($userName);

            $total = $repos->reduce(function ($carry, $item) use ($userName) {

                // Calculate each parameter the with the respective factor
                $watchers = $item['watchers_count'] * app('settings')->factor_repository_watchers;
                $forks = $item['forks_count'] * app('settings')->factor_repository_forks;
                $size = $item['size'] * app('settings')->factor_repository_size;
                $stars = $item['stargazers_count'] * app('settings')->factor_repository_stars;

                $name = $item['name'];
                $owner = $item['owner']['login'];

                $contributions = $this->getGithubRepositoryContributions($owner, $name, $userName);
                $contributions *= app('settings')->factor_repository_contributions;

                return $carry + $watchers + $forks + $size + $stars + $contributions;
            }, 0);
        }

        return $total;
    }

    /**
     * Get the contributions of a user in a given github repository.
     *
     * @param $owner string
     * @param $repositoryName string
     * @param $user string
     *
     * @return int
     */
    private function getGithubRepositoryContributions(string $owner, string $name, string $user)
    {
        $contributors = Github::repo()->contributors($owner, $name, false);
        $contributions = $contributors->reduce(function ($carry, $item) use ($user) {
            if ($item['login'] === $user) {
                return $carry + $item['contributions'];
            }

            return $carry;
        });

        return $contributions;
    }
}
