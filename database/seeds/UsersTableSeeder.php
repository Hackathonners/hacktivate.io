<?php

use App\Alexa\Models\Role;
use App\Alexa\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            'diogo2couto@gmail.com',
            'fntneves@gmail.com',
            'hugo.b.brandao@gmail.com',
        ];

        $adminRole = Role::whereType(Role::ROLE_ADMINISTRATOR)->first();
        foreach ($admins as $email) {
            User::create([
                'name' => '',
                'email' => $email,
                'github' => '',
                'password' => bcrypt(Str::random()),
                'role_id' => $adminRole->id,
            ]);
        }
    }
}
