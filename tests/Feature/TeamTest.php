<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Alexa\Models\Team;
use App\Alexa\Models\User;

class TeamTest extends TestCase
{
    public function test_user_can_create_a_team()
    {
        $owner = factory(User::class)->create();
        $requestData = [
            'name' => 'Team test',
            'description' => 'An awesome team! Well, at least we are convinced...',
        ];

        $response = $this->actingAs($owner)
            ->post(route('teams.store'), $requestData);

        $this->assertEquals(1, Team::count());
        $newTeam = Team::latest('id')->first();
        $response->assertRedirect(route('members.index', $newTeam->id));
        $team = Team::first();
        $this->assertEquals($requestData['name'], $team->name);
        $this->assertEquals($requestData['description'], $team->description);
        $this->assertTrue($team->isOwner($owner), 'User does not own the new team.');
        $this->assertEquals($owner->id, $team->users()->first()->id, 'Team does not contain specified members.');
    }

    public function test_user_leaves_current_team_when_creates_a_new_team()
    {
        $owner = factory(User::class)->create();
        $oldTeam = factory(Team::class)->create(['user_id' => $owner->id]);
        $oldTeam->addMember($owner);
        $oldTeamMember = factory(User::class)->create(['team_id' => $oldTeam->id]);
        $requestData = [
            'name' => 'Team test',
            'description' => 'An awesome team! Well, at least we are convinced...',
        ];

        $response = $this->actingAs($owner)
            ->post(route('teams.store'), $requestData);

        $this->assertEquals(2, Team::count());
        $newTeam = Team::latest('id')->first();
        $response->assertRedirect(route('members.index', $newTeam->id));
        $this->assertEquals($requestData['name'], $newTeam->name);
        $this->assertEquals($requestData['description'], $newTeam->description);
        $this->assertTrue($newTeam->isOwner($owner), 'User does not own the new team.');
        $this->assertEquals($owner->id, $newTeam->users()->first()->id, 'Team does not contain specified members.');
        $oldTeam->refresh();
        $this->assertEquals(1, $oldTeam->users()->count());
        $this->assertTrue($oldTeam->isOwner($oldTeamMember), 'The member of the old team is not the owner.');
        $this->assertEquals($oldTeamMember->id, $oldTeam->users()->first()->id, 'The old team does not contain specified members.');
    }
}
