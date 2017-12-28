<?php

namespace Tests\Feature;

use Mockery as m;
use Tests\TestCase;
use App\Alexa\Models\User;
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
        $response->assertRedirect(route('home'));
        $this->assertEquals(1, User::count());
        $user = User::first();
        $this->assertEquals($githubUser->name, $user->name);
        $this->assertEquals($githubUser->email, $user->email);
        $this->assertEquals($githubUser->nickname, $user->github);
        $this->assertEquals($githubUser->user['avatar_url'], $user->avatar);
    }

    public function test_no_user_is_updated_when_login_exists()
    {
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
