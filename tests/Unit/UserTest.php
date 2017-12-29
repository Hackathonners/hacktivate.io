<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Alexa\Models\Team;
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

    public function testFilterUsersByNicknameOrEmail()
    {
        $userMatchingNickname = factory(User::class)->create(['github' => 'fntneves']);
        $userMatchingEmail = factory(User::class)->create(['email' => 'fntneves@hi.me']);
        $userNotMatchingEmail = factory(User::class)->create(['email' => 'hi@fntneves.me']);
        $userNotMatching = factory(User::class)->create(['email' => 'hello@fake.me']);

        $users = User::filterByEmailOrNickname('fntneves')->get();

        $this->assertEquals(2, $users->count());
        $this->assertArraySubset([$userMatchingNickname->id, $userMatchingEmail->id], $users->pluck('id'));
    }

    public function testFilterUsersWithoutTeam()
    {
        $userWithTeam = factory(User::class)->create();
        $team = factory(Team::class)->create(['user_id' => $userWithTeam->id]);
        $userWithTeam->team()->associate($team);
        $userWithTeam->save();
        $userWithoutTeam = factory(User::class)->create();

        $users = User::withoutTeam()->get();

        $this->assertEquals(1, $users->count());
        $this->assertEquals($userWithoutTeam->id, $users->first()->id);
    }
}
