<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Alexa\Models\Role;

class RoleTest extends TestCase
{
    public function testRoleIsAdmin()
    {
        $role = new Role();
        $role->type = Role::ROLE_ADMINISTRATOR;

        $this->assertTrue($role->isAdmin());
    }

    public function testRoleIsNotAdmin()
    {
        $role = new Role();
        $role->type = Role::ROLE_USER;

        $this->assertFalse($role->isAdmin());
    }

    public function testRoleIsUser()
    {
        $role = new Role();
        $role->type = Role::ROLE_USER;

        $this->assertTrue($role->isUser());
    }

    public function testRoleIsNotUser()
    {
        $role = new Role();
        $role->type = Role::ROLE_ADMINISTRATOR;

        $this->assertFalse($role->isUser());
    }
}
