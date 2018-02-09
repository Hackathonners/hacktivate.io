<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Alexa\Models\Team;
use App\Alexa\Models\User;
use App\Mail\TeamAccepted;
use Illuminate\Support\Facades\Mail;

class SendTeamAcceptedMailTest extends TestCase
{
    public function test_send_notification_to_accepted_teams()
    {
        Mail::fake();
        $eligibleTeam = factory(Team::class)->create();
        $eligibleTeam->addMember($eligibleTeam->owner);
        $eligibleTeam->addMember(factory(User::class)->create());

        // Create an ineligible team.
        $ineligibleTeam = factory(Team::class)->create();
        $ineligibleTeam->addMember(factory(User::class)->create());

        $this->artisan('emails:teams:accepted');

        Mail::assertSent(TeamAccepted::class, 2);
        $eligibleTeam->users->each(function ($user) use ($eligibleTeam) {
            Mail::assertSent(TeamAccepted::class, function ($mail) use ($user, $eligibleTeam) {
                return $mail->hasTo($user->email)
                    && $mail->user->email === $user->email
                    && $mail->team->id === $eligibleTeam->id;
            });
        });
    }
}
