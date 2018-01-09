<?php

use App\Alexa\Models\Role;
use App\Alexa\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admins = [
          [
            'name' => 'Diogo Couto',
            'email' => 'diogo2couto@gmail.com',
            'github' => 'djcouto',
          ],
        ];

        $adminRole = Role::whereType(Role::ROLE_ADMINISTRATOR)->first();
        foreach ($admins as $user) {
            User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'github' => $user['github'],
            'password' => bcrypt(Str::random()),
            'role_id' => $adminRole->id,
          ]);
        }
    }
}
