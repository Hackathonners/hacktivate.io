<?php

namespace App\Http\Controllers\Admin;

use App\Alexa\Models\User;
use App\Http\Controllers\Controller;

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
        $this->middleware('can.admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $usersWithCompleteApplication = $users->filter(function ($value, $key) {
            return $value->hasCompleteApplication();
        });
        $usersWithoutCompleteApplication = $users->diff($usersWithCompleteApplication);

        return view('admin.users.index', compact('usersWithCompleteApplication', 'usersWithoutCompleteApplication'));
    }
}
