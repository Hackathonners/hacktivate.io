<?php

namespace App\Console\Commands;

use App\Mail\Feedback;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendFeedbackMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:feedback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send feedback e-mails to attendees.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $attendees = \App\Alexa\Models\User::whereCheckedIn(true)->get();

        $attendees->each(function ($attendee) {
            Mail::to($attendee)->send(new Feedback($attendee));
        });
    }
}
