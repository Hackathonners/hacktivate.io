<?php

namespace App\Http\Controllers;

use App\Alexa\Models\Team;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Team\CreateRequest;

class TeamsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Team\CreateRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $team = DB::transaction(function () use ($request) {
            $user = auth()->user();

            $user->leaveCurrentTeam();

            $team = new Team($request->all());
            $team->owner()->associate($user);
            $team->save();

            $team->addMember($user);

            return $team;
        });

        return redirect()
            ->route('members.index', $team->id)
            ->with('status', 'Your team was successfully created. Add members to your team.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = auth()->user()->ownerTeam()->findOrFail($id);

        return view('teams.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Team\CreateRequest  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CreateRequest $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $team = auth()->user()->ownerTeam()->findOrFail($id);
            $team->fill($request->all());
            $team->save();
        });

        return back()
            ->with('status', 'Your team was successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
