<?php

use Carbon\Carbon;
use App\Alexa\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create([
            'applications_start_at' => Carbon::today(),
            'applications_end_at' => Carbon::tomorrow(),
            'min_team_members' => 4,
            'max_team_members' => 5,
        ]);
    }
}
