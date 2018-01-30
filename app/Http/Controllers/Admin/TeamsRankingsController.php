<?php

namespace App\Http\Controllers\Admin;

use App\Alexa\Models\Team;
use App\Alexa\Score\ScoreTeam;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TeamsRankingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can.admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($useCache = true)
    {
        $rankedTeams = DB::transaction(function () use ($useCache) {
            $score = new ScoreTeam();
            $teams = Team::all();
            $rankedTeams = collect([]);

            foreach ($teams as $team) {
                $rankedTeams->push([
                    'id' => $team->id,
                    'name' => $team->name,
                    'members' => $team->users()->count(),
                    'rank' => ScoreTeam::getTeamScore($team),
                ]);
            }

            return $rankedTeams;
        });

        $rankedTeams = $rankedTeams->sortByDesc('score');

        return view('teams.rankings.index', compact('rankedTeams'));
    }

    /**
     * Refresh the listing of the resource resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh()
    {
        return $this->index(false);
    }
}
