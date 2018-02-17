<?php

namespace App\Mail;

use App\Alexa\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Feedback extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The accepted user.
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

        return $this->subject('Thank you for being part of Hacktivate!')
            ->markdown('emails.feedback', compact('user'));
    }
}
