<?php

use App\Alexa\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->type = Role::ROLE_USER;
        $role->save();

        $role = new Role();
        $role->type = Role::ROLE_ADMINISTRATOR;
        $role->save();
    }
}
