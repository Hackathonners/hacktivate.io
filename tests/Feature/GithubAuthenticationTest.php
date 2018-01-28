<?php

namespace Tests\Feature;

use Mockery as m;
use Tests\TestCase;
use App\Alexa\Models\Role;
use App\Alexa\Models\User;
use App\Mail\UserRegistered;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class GithubAuthenticationTest extends TestCase
{
    protected $callbackUri = 'login/github/callback';

    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    public function test_user_is_created_after_first_login()
    {
        Mail::fake();
        $this->withoutExceptionHandling();
        $githubUser = new \Laravel\Socialite\Two\User();
        $githubUser->map([
            'name' => 'Francisco Neves',
            'email' => 'hi@francisconeves.me',
            'nickname' => 'fntneves',
            'user' => [
                'avatar_url' => 'https://avatar.fake',
                'location' => 'Guimarães, Portugal',
            ],
        ]);

        // Mock Socialite to return mocked user on callback.
        $this->mockSocialiteFacade($githubUser);

        // Call login callback.
        $response = $this->get($this->callbackUri);

        // Assert that user has been created and match Github's mocked data.
        Mail::assertSent(UserRegistered::class, function ($mail) use ($githubUser) {
            return $mail->hasTo($githubUser->email) && $mail->user->email === $githubUser->email;
        });
        $response->assertRedirect(route('home'));
        $this->assertEquals(1, User::count());
        $user = User::first();
        $this->assertEquals($githubUser->name, $user->name);
        $this->assertEquals($githubUser->email, $user->email);
        $this->assertEquals($githubUser->nickname, $user->github);
        $this->assertEquals($githubUser->user['avatar_url'], $user->avatar);
        $this->assertEquals(Role::ROLE_USER, $user->role->type);
    }

    public function test_nickname_is_used_when_user_does_not_have_a_name()
    {
        Mail::fake();
        $this->withoutExceptionHandling();
        $githubUser = new \Laravel\Socialite\Two\User();
        $githubUser->map([
            'email' => 'hi@francisconeves.me',
            'nickname' => 'fntneves',
            'user' => [
                'avatar_url' => 'https://avatar.fake',
                'location' => 'Guimarães, Portugal',
            ],
        ]);

        // Mock Socialite to return mocked user on callback.
        $this->mockSocialiteFacade($githubUser);

        // Call login callback.
        $response = $this->get($this->callbackUri);

        // Assert that user has been created and match Github's mocked data.
        Mail::assertSent(UserRegistered::class, function ($mail) use ($githubUser) {
            return $mail->hasTo($githubUser->email) && $mail->user->email === $githubUser->email;
        });
        $response->assertRedirect(route('home'));
        $this->assertEquals(1, User::count());
        $user = User::first();
        $this->assertEquals($githubUser->nickname, $user->name);
        $this->assertEquals($githubUser->email, $user->email);
        $this->assertEquals($githubUser->nickname, $user->github);
        $this->assertEquals($githubUser->user['avatar_url'], $user->avatar);
        $this->assertEquals(Role::ROLE_USER, $user->role->type);
    }

    public function test_no_user_is_updated_when_login_exists()
    {
        Mail::fake();
        $user = factory(User::class)->create();

        $githubUser = new \Laravel\Socialite\Two\User();
        $githubUser->map([
            'name' => $user->name,
            'email' => $user->email,
            'nickname' => 'fntneves_new',
            'user' => [
                'avatar_url' => 'https://avatar.fake_new',
                'location' => 'Guimarães, Portugal',
            ],
        ]);

        // Mock Socialite to return mocked user on callback.
        $this->mockSocialiteFacade($githubUser);

        // Call login callback.
        $response = $this->get($this->callbackUri);

        // Assert that existing user matches Github's mocked data.
        Mail::assertNotSent(UserRegistered::class);
        $response->assertRedirect(route('home'));
        $this->assertEquals(1, User::count());
        $user = User::first();
        $this->assertEquals($githubUser->name, $user->name);
        $this->assertEquals($githubUser->email, $user->email);
        $this->assertEquals($githubUser->nickname, $user->github);
        $this->assertEquals($githubUser->user['avatar_url'], $user->avatar);
    }

    public function test_redirect_on_login_fail()
    {
        // Mock Socialite to throw exception on callback.
        Socialite::shouldReceive('driver')
            ->once()
            ->with('github')
            ->andThrow(\Laravel\Socialite\Two\InvalidStateException::class);

        // Call login callback.
        $response = $this->get($this->callbackUri);

        // Assert that guest is redirected to home and no user is created.
        $response->assertRedirect('/');
        $this->assertEquals(0, User::count());
    }

    public function test_admin_role_is_not_overridden_on_login()
    {
        $this->withoutExceptionHandling();
        factory(User::class)->states('admin')->create([
            'email' => 'hi@francisconeves.me',
        ]);
        $githubUser = new \Laravel\Socialite\Two\User();
        $githubUser->map([
            'name' => 'Francisco Neves',
            'email' => 'hi@francisconeves.me',
            'nickname' => 'fntneves',
            'user' => [
                'avatar_url' => 'https://avatar.fake',
                'location' => 'Guimarães, Portugal',
            ],
        ]);

        // Mock Socialite to return mocked user on callback.
        $this->mockSocialiteFacade($githubUser);

        // Call login callback.
        $response = $this->get($this->callbackUri);

        // Assert that user has been created and has the Admin role.
        $response->assertRedirect(route('home'));
        $this->assertEquals(1, User::count());
        $user = User::first();
        $adminType = Role::ROLE_ADMINISTRATOR;
        $this->assertEquals($adminType, $user->role->type);
    }

    private function mockSocialiteFacade($githubUser)
    {
        $githubProvider = m::mock(\Laravel\Socialite\Two\ProviderInterface::class)
            ->shouldReceive('user')
            ->once()
            ->andReturn($githubUser)
            ->getMock();

        Socialite::shouldReceive('driver')
            ->once()
            ->with('github')
            ->andReturn($githubProvider);
    }
}
