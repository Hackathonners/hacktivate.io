<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use App\Alexa\Models\Role;
use App\Alexa\Models\User;
use Illuminate\Support\Str;
use App\Mail\UserRegistered;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\AbstractUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
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
    protected $redirectTo = '/profile';

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
            $githubUser->avatar = $githubUser->user['avatar_url'] ?? null;

            $user = $this->findOrCreateUser($githubUser);
            $this->guard()->login($user, true);

            if ($user->wasRecentlyCreated) {
                Mail::to($user)->send(new UserRegistered($user));
            }

            return redirect()->intended($this->redirectPath());
        } catch (InvalidStateException $e) {
            return redirect('/');
        }
    }

    /**
     * Find or create a new user with provided Github's data.
     *
     * @param  \Laravel\Socialite\AbstractUser  $socialiteUser
     *
     * @return \App\Alexa\Models\User
     */
    protected function findOrCreateUser(AbstractUser $socialiteUser)
    {
        return DB::transaction(function () use ($socialiteUser) {
            $user = User::whereEmail($socialiteUser->getEmail())
                ->firstOrNew([]);

            $user->fill([
                'name' => $socialiteUser->getName() ?? $socialiteUser->getNickname(),
                'email' => $socialiteUser->getEmail(),
                'github' => $socialiteUser->getNickname(),
                'avatar' => $socialiteUser->getAvatar(),
                'location' => $socialiteUser->user['location'] ?? $user->location,
                'password' => bcrypt(Str::random()),
            ]);

            if (! $user->hasRole()) {
                $user->role()->associate(Role::whereType(Role::ROLE_USER)->first());
            }

            $user->save();

            return $user;
        });
    }
}
