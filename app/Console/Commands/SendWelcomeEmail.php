<?php

namespace App\Console\Commands;

use App\Mail\UserRegistered;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:welcome';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send welcome e-mail to users.';

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
        $users = \App\Alexa\Models\User::all();

        $users->each(function ($user) {
            Mail::to($user)->send(new UserRegistered($user));
        });
    }
}
