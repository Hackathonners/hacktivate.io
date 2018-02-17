<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Mail\Feedback;
use App\Alexa\Models\User;
use Illuminate\Support\Facades\Mail;

class SendFeedbackMailTest extends TestCase
{
    public function test_send_feedback_email_to_attendees()
    {
        Mail::fake();
        $attendees = factory(User::class, 3)->create(['checked_in' => true]);
        $users = factory(User::class, 2)->create();

        $this->artisan('emails:feedback');

        Mail::assertSent(Feedback::class, 3);
        $attendees->each(function ($attendee) {
            Mail::assertSent(Feedback::class, function ($mail) use ($attendee) {
                return $mail->hasTo($attendee->email)
                    && $mail->user->email === $attendee->email;
            });
        });
    }
}
