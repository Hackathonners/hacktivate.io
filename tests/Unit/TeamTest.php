<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Alexa\Models\Team;
use App\Alexa\Models\User;

class TeamTest extends TestCase
{
    public function testisOwnerOfATeam()
    {
        $owner = factory(User::class)->create();
        $user = factory(User::class)->create();
        $team = factory(Team::class)->create([
            'user_id' => $owner->id,
        ]);

        $this->assertTrue($team->isOwner($owner));
        $this->assertFalse($team->isOwner($user));
    }
}
