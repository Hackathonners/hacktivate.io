<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Alexa\Models\User;
use App\Mail\UserRegistered;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailTest extends TestCase
{
    public function testWelcomeEmailIsSent()
    {
        Mail::fake();
        $users = factory(User::class, 5)->create();

        $this->artisan('emails:welcome');

        $users->each(function ($user) {
            Mail::assertSent(UserRegistered::class, function ($mail) use ($user) {
                return $mail->hasTo($user->email) && $mail->user->email === $user->email;
            });
        });
    }
}
