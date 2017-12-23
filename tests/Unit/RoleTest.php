<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Alexa\Models\Role;
use App\Alexa\Models\User;

class RoleTest extends TestCase
{
    public function testRoleIsAdmin()
    {
        $role = factory(Role::class)->states('admin')->create();

        $this->assertTrue($role->isAdmin());
    }

    public function testRoleIsNotAdmin()
    {
        $role = factory(Role::class)->states('user')->create();

        $this->assertFalse($role->isAdmin());
    }

    public function testRoleIsUser()
    {
        $role = factory(Role::class)->states('user')->create();

        $this->assertTrue($role->isUser());
    }

    public function testRoleIsNotUser()
    {
        $role = factory(Role::class)->states('admin')->create();

        $this->assertFalse($role->isUser());
    }
}
