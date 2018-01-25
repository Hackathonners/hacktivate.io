<?php

namespace App\Mail;

use App\Alexa\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistered extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The registered user.
     *
     * @var \App\Alexa\Models\User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param  \App\Alexa\Models\User  $user
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;

        return $this->subject('Welcome to Hacktivate')
            ->markdown('emails.users.registered', compact('user'));
    }
}
