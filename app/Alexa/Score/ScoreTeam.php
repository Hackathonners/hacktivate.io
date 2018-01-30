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
    /**
     * Get the score of this team.
     *
     * @param $useCache boolean
     * @param $team App\AlexaModels\Team;
     *
     * @return int
     */
    public static function getTeamScore(Team $team, $useCache = true)
    {
        if ($useCache && Cache::has('team-'.$team->id)) {
            return Cache::get('team-'.$team->id);
        }

        $members = $team->users;
        $score = 0;

        foreach ($members as $member) {
            $score += self::getUserScore($member, $useCache);
        }

        // Update cache
        $expiresAt = Carbon::today()->addDays(1);
        Cache::put('team-'.$team->id, $score, $expiresAt);

        return $score;
    }

    /**
     * Get the score of this user.
     *
     * @param $user App\Alexa\Models\User
     * @param $useCache boolean
     *
     * @return int
     */
    public static function getUserScore(User $user, $useCache = true)
    {
        if ($useCache && Cache::has('user-'.$user->id)) {
            return Cache::get('user-'.$user->id);
        }

        $total = 0;

        // Get the github user
        $userInfo = GitHub::user()->show($user->github);

        // Check if the username exists
        throw_if(empty($userInfo), new GithubHandlerException($user->github, 'The invalid username given.'));

        // Get info about the user
        $publicRepos = $userInfo['public_repos'] * app('settings')->factor_number_repositories;
        $publicGists = $userInfo['public_gists'] * app('settings')->factor_gists;
        $followers = $userInfo['followers'] * app('settings')->factor_followers;

        // Get user contributions in his own github
        if ($publicRepos > 0) {
            $total = self::getGithubUserContributions($userInfo['login'], $userInfo['login']);
        }

        // Get organizations info
        $organizations = collect(GitHub::user()->organizations($user->github));

        // Get user contributions in his organizations
        $total = $organizations->reduce(function ($carry, $organization) use ($total, $userInfo) {
            return $carry + self::getGithubUserContributions($userInfo['login'], $organization['login']);
        }, $total);

        // Calculate final score
        $score = $total + $publicRepos + $publicGists + $followers;

        // Update cache
        $expiresAt = Carbon::today()->addWeeks(1);
        Cache::put('user-'.$user->id, $score, $expiresAt);

        return $score;
    }

    /**
     * Get the github contributions of a given user in a given user/organization.
     *
     * @param $user/organization string
     * @param $contributor string
     *
     * @return int
     */
    private static function getGithubUserContributions(string $username, string $contributor)
    {
        // Get the user public repositories
        $repos = collect(Github::user()->repositories($contributor));

        $total = $repos->reduce(function ($carry, $item) use ($username) {

            // Calculate each parameter the with the respective factor
            $watchers = $item['watchers_count'] * app('settings')->factor_repository_watchers;
            $forks = $item['forks_count'] * app('settings')->factor_repository_forks;
            $size = $item['size'] * app('settings')->factor_repository_size;
            $stars = $item['stargazers_count'] * app('settings')->factor_repository_stars;

            $name = $item['name'];
            $owner = $item['owner']['login'];

            $contributions = 0;
            if ($item['size'] !== 0) {
                $contributions = self::getGithubRepositoryContributions($owner, $name, $username);
            }
            $contributions *= app('settings')->factor_repository_contributions;

            return $carry + $watchers + $forks + $size + $stars + $contributions;
        }, 0);

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
    private static function getGithubRepositoryContributions(string $owner, string $name, string $user)
    {
        $contributors = collect(Github::repo()->contributors($owner, $name, false));
        $contributions = $contributors->reduce(function ($carry, $item) use ($user) {
            if ($item['login'] === $user) {
                return $carry + $item['contributions'];
            }

            return $carry;
        });

        return $contributions;
    }
}
