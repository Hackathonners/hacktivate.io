<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Alexa\Models\Team;
use App\Alexa\Models\User;

class TeamMemberTest extends TestCase
{
    public function test_user_can_add_a_member_to_their_team()
    {
        $team = factory(Team::class)->create();
        $newMember = factory(User::class)->create();
        $requestData = ['github' => $newMember->github];

        $response = $this->actingAs($team->owner)
            ->post(route('members.store', $team->id), $requestData);

        $response->assertSuccessful();
        $team->refresh();
        $this->assertTrue($team->users()->whereGithub($newMember->github)->exists());
    }

    public function test_user_may_not_change_team_out_of_applications_period()
    {
        $this->disableApplicationsPeriod();
        $team = factory(Team::class)->create();
        $member = factory(User::class)->create(['team_id' => $team->id]);

        // Add member to team.
        $newMember = factory(User::class)->create();
        $requestData = ['github' => $newMember->github];
        $response = $this->actingAs($team->owner)
            ->post(route('teams.store', $team->id), $requestData);

        $team->refresh();
        $this->assertEquals(1, $team->users->count());
        $this->assertEquals(trans('settings.applications_closed'), app('session')->get('error'));

        // Delete member from team.
        $response = $this->actingAs($team->owner)
            ->delete(route('teams.destroy', ['id' => $member->id]));

        $this->assertEquals(1, $team->users->count());
        $this->assertEquals(trans('settings.applications_closed'), app('session')->get('error'));
    }

    public function test_user_can_remove_a_member_from_their_team()
    {
        $team = factory(Team::class)->create();
        $member = factory(User::class)->create(['team_id' => $team->id]);
        $requestData = ['github' => $member->github];

        $response = $this->actingAs($team->owner)
            ->delete(route('members.destroy', [
                'id' => $team->id,
                'member' => $member->github,
            ]), $requestData);

        $response->assertSuccessful();
        $team->refresh();
        $this->assertFalse($team->users()->whereGithub($member->github)->exists());
    }

    public function test_user_may_not_add_a_member_when_team_is_full()
    {
        $team = factory(Team::class)->create();
        $team->users()->saveMany(factory(User::class, 4)->make());
        $newMember = factory(User::class)->create();
        $requestData = ['github' => $newMember->github];

        $response = $this->actingAs($team->owner)
            ->post(route('members.store', $team->id), $requestData);

        $response->assertStatus(403);
        $response->assertJson(['message' => 'The team is full.']);
        $team->refresh();
        $this->assertFalse($team->users()->whereGithub($newMember->github)->exists());
    }

    public function test_user_see_not_found_when_add_new_member_of_a_not_owning_team()
    {
        $team = factory(Team::class)->create();
        $unauthorizedUser = factory(User::class)->create();
        $newMember = factory(User::class)->create();
        $requestData = ['github' => $newMember->github];

        $response = $this->actingAs($unauthorizedUser)
            ->post(route('members.store', $team->id), $requestData);

        $response->assertStatus(404);
        $team->refresh();
        $this->assertFalse($team->users()->whereGithub($newMember->github)->exists());
    }

    public function test_user_see_not_found_when_removes_member_from_a_not_owning_team()
    {
        $team = factory(Team::class)->create();
        $unauthorizedUser = factory(User::class)->create();
        $member = factory(User::class)->create(['team_id' => $team->id]);
        $requestData = ['github' => $member->github];

        $response = $this->actingAs($unauthorizedUser)
            ->delete(route('members.destroy', [
                'id' => $team->id,
                'member' => $member->github,
            ]), $requestData);

        $response->assertStatus(404);
        $team->refresh();
        $this->assertTrue($team->users()->whereGithub($member->github)->exists());
    }

    public function test_user_can_remove_themselves_from_their_team()
    {
        $team = factory(Team::class)->create();
        $member = factory(User::class)->create(['team_id' => $team->id]);
        $requestData = ['github' => $member->github];

        $response = $this->actingAs($member)
            ->post(route('team.members.leave',
                $member->id
            ), $requestData);

        $response->assertRedirect(route('home'));
        $team->refresh();
        $this->assertFalse($team->users()->whereGithub($member->github)->exists());
    }
}
