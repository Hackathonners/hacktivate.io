<?php

namespace App\Console\Commands;

use App\Mail\TeamAccepted;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTeamAcceptedMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:teams:accepted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send e-mails to accepted teams.';

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
        $teams = \App\Alexa\Models\Team::with('users')->get();

        $teams->each(function ($team) {
            if (! $team->isEligibleForAcceptance()) {
                return;
            }

            $team->users->each(function ($user) use ($team) {
                Mail::to($user)->send(new TeamAccepted($team, $user));
            });
        });
    }
}
