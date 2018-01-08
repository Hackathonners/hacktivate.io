<?php

use App\Alexa\Models\Role;
use App\Alexa\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    protected $admins = [
      [
        'name' => 'Diogo Couto',
        'email' => 'diogo2couto@gmail.com',
        'github' => 'djcouto',
      ],
    ];

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $adminType = Role::ROLE_ADMINISTRATOR;
        foreach ($this->admins as $user) {
            User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'github' => $user['github'],
            'password' => bcrypt(Str::random()),
            'role_id' => Role::whereType($adminType)->first()->id,
          ]);
        }
    }
}
