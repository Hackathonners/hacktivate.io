<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $this->call(RolesTableSeeder::class);
            $this->call(SettingsTableSeeder::class);

            // Only run the seeders registered here when we are in production,
            // otherwise keep it clean or it would somehow intefer with the
            // tests scenario preparation since data is stored in database.
            if (! App::environment('testing')) {
                $this->call(UsersTableSeeder::class);
            }
        });
    }
}
