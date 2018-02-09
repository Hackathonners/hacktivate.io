<?php

namespace App\Mail;

use App\Alexa\Models\Team;
use App\Alexa\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamAccepted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The accepted team.
     *
     * @var \App\Alexa\Models\Team
     */
    public $team;

    /**
     * The accepted user.
     *
     * @var \App\Alexa\Models\User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param  \App\Alexa\Models\Team  $team
     * @param  \App\Alexa\Models\User  $user
     *
     * @return void
     */
    public function __construct(Team $team, User $user)
    {
        $this->user = $user;
        $this->team = $team;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $team = $this->team;

        return $this->subject('Congratulations, your team is now accepted!')
            ->markdown('emails.teams.accepted', compact('user', 'team'));
    }
}
