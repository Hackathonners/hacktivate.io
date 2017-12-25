<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Socialite;
use App\Alexa\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Two\InvalidStateException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class GithubLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Github Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();
            $user = User::whereEmail($githubUser->getEmail())->first();

            if (! $user) {
                $user = $this->create((array) $githubUser);
                // TODO: Send welcome e-mail.
            }

            $this->guard()->login($user);

            return redirect()->intended($this->redirectPath());
        } catch (InvalidStateException $e) {
            return redirect('/');
        }
    }

    /**
     * Create a new user instance after a valid Github authentication.
     *
     * @param  array  $data
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = new User();
            $user->fill([
                'name' => $data['name'],
                'email' => $data['email'],
                'github' => $data['nickname'],
                'password' => bcrypt(Str::random()),
            ]);
            $user->role()->associate(Role::whereType('user')->first());
            $user->save();

            return $user;
        });
    }
}
