<?php

use Carbon\Carbon;
use App\Alexa\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Settings::create([
            'projects_submission_start_at' => Carbon::now(),
        ]);
    }
}
