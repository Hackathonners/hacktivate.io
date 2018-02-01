<?php

namespace App\Http\Controllers;

use App\Alexa\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\UpdateRequest;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can.apply')->only('edit', 'update');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->ajax() ?: abort(404);

        $search = $request->get('query');
        $users = User::query();

        if ($search) {
            $users = User::where('id', '!=', auth()->id())
                ->filterByEmailOrNickname($search)
                ->withoutTeam();
        }

        return $users->paginate();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
        return view('users.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\User\UpdateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = Auth::user();
            $user->fill($request->input());
            $user->save();
        });

        return redirect()->route('users.edit')->with('status', 'Your profile was successfully updated.');
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
        DB::transaction(function () use ($id) {
            $user = auth()->user()->findOrFail($id);
            $user->leaveCurrentTeam();
        });

        return redirect()->route('home')->with('status', 'You\'ve successfully left the team.');
    }
}
