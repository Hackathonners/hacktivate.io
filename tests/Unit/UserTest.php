<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Alexa\Models\User;

class UserTest extends TestCase
{
    public function testUserHasCompleteProfile()
    {
        $user = factory(User::class)->make();
        $user->fill([
            'dietary_restrictions' => null,
            'special_needs' => null,
        ]);

        $this->assertTrue($user->hasCompleteProfile());
    }

    public function testUserHasNotCompleteProfile()
    {
        $user = factory(User::class)->make();
        $user->fill([
            'gender' => null,
            'school' => null,
        ]);

        $this->assertFalse($user->hasCompleteProfile());
    }
}
