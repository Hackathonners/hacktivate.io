<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Alexa\Models\Team;
use App\Alexa\Models\User;
use App\Exceptions\TeamException;

class TeamTest extends TestCase
{
    public function testIsOwnerOfATeam()
    {
        $owner = factory(User::class)->create();
        $user = factory(User::class)->create();
        $team = factory(Team::class)->create(['user_id' => $owner->id]);

        $this->assertTrue($team->isOwner($owner));
        $this->assertFalse($team->isOwner($user));
    }

    public function testTeamIsEligibleForAcceptance()
    {
        $eligibleTeam = factory(Team::class)->create();
        $eligibleTeam->users()->saveMany(factory(User::class, 2)->make());
        $ineligibleTeam = factory(Team::class)->create();
        $ineligibleTeam->users()->saveMany(factory(User::class, 1)->make());

        $this->assertTrue($eligibleTeam->isEligibleForAcceptance());
        $this->assertFalse($ineligibleTeam->isEligibleForAcceptance());
    }

    public function testTeamIsFull()
    {
        $fullTeam = factory(Team::class)->create();
        $fullTeam->users()->saveMany(factory(User::class, 4)->make());
        $notFullTeam = factory(Team::class)->create();
        $notFullTeam->users()->saveMany(factory(User::class, 3)->make());

        $this->assertTrue($fullTeam->isFull());
        $this->assertFalse($notFullTeam->isFull());
    }

    public function testRemoveTeamMember()
    {
        $team = factory(Team::class)->create();
        $owner = $team->owner;
        $owner->team()->associate($team);
        $owner->save();
        $member = factory(User::class)->create(['team_id' => $team->id]);

        $team->removeMember($member);

        $this->assertEquals(1, $team->users->count());
        $this->assertEquals($owner->id, $team->users()->first()->id);
    }

    public function testTeamIsDeletedWhenLastElementIsRemoved()
    {
        $team = factory(Team::class)->create();
        $owner = $team->owner;
        $owner->team()->associate($team);
        $owner->save();

        $team->removeMember($owner);

        $this->assertEquals(0, Team::count());
        $this->assertTrue($team->trashed());
        $this->assertFalse($owner->hasTeam());
    }

    public function testNewOwnerIsChosenWhenTheOwnerIsRemoved()
    {
        $team = factory(Team::class)->create();
        $owner = $team->owner;
        $owner->team()->associate($team);
        $owner->save();
        $member = factory(User::class)->create(['team_id' => $team->id]);

        $team->removeMember($owner);

        $this->assertFalse($team->trashed());
        $this->assertEquals(1, $team->users->count());
        $this->assertEquals($member->id, $team->users()->first()->id);
        $this->assertTrue($team->isOwner($member));
    }

    public function testThrowExceptionWhenTeamIsFull()
    {
        $team = factory(Team::class)->create();
        $team->users()->saveMany(factory(User::class, 4)->make());
        $user = factory(User::class)->create();

        try {
            $team->addMember($user);
            $this->fail('Team exception was not threw.');
        } catch (TeamException $e) {
            $this->assertEquals(4, $team->users()->count());
        }
    }
}
