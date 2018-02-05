<?php

namespace App\Http\Controllers;

use App\Alexa\Models\Team;
use App\Alexa\Models\User;
use App\Exceptions\TeamException;
use Illuminate\Support\Facades\DB;
use App\Rules\User\EligibleForNewTeam;
use App\Http\Requests\TeamMember\CreateRequest;

class TeamMembersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can.apply');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int  $teamId
     *
     * @return \Illuminate\Http\Response
     */
    public function index($teamId)
    {
        $team = DB::transaction(function () use ($teamId) {
            return auth()->user()->ownerTeam()
                ->with('users')
                ->findOrFail($teamId);
        });

        return view('team_members.index', compact('team'));
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  \App\Http\Requests\TeamMember\CreateRequest  $request
     * @param  int  $teamId
     *
     * @return array
     */
    public function store(CreateRequest $request, $teamId)
    {
        try {
            DB::transaction(function () use ($request, $teamId) {
                $team = auth()->user()->ownerTeam()->findOrFail($teamId);

                $this->validate($request, [
                    'github' => [new EligibleForNewTeam()],
                ]);

                $member = User::whereGithub($request->input('github'))->first();
                $team->addMember($member);
            });
        } catch (TeamException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }

        return ['message' => 'The user was successfully added to your team.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $teamId
     * @param  string  $memberGithub
     *
     * @return array
     */
    public function destroy($teamId, $memberGithub)
    {
        DB::transaction(function () use ($teamId, $memberGithub) {
            $team = auth()->user()->ownerTeam()->findOrFail($teamId);
            $member = $team->users()->whereGithub($memberGithub)->firstOrFail();

            $team->removeMember($member);
        });

        return ['message' => 'The user was successfully removed from your team.'];
    }

    /**
     * Remove a user from their team. TODO: Change this.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function leave($id)
    {
        DB::transaction(function () use ($id) {
            $user = auth()->user()->findOrFail($id);
            $user->leaveCurrentTeam();
        });

        return redirect()->route('home')->with('status', 'You\'ve successfully left the team.');
    }
}
