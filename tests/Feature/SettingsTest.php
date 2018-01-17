<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Alexa\Models\User;
use App\Alexa\Models\Settings;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SettingsTest extends TestCase
{
    use DatabaseTransactions;

    protected $admin;
    protected $settings;

    public function setUp()
    {
        parent::setUp();
        $this->admin = factory(User::class)->states('admin')->create();
        $this->settings = app('settings');
    }

    public function test_admin_can_update_settings()
    {
        $applicationsStart = Carbon::tomorrow();
        $applicationsEnd = Carbon::tomorrow()->addDays(1);
        $minTeamMembers = 1;
        $maxTeamMembers = 5;
        $requestData = [
            'applications_start_at' => $applicationsStart,
            'applications_end_at' => $applicationsEnd,
            'min_team_members' => $minTeamMembers,
            'max_team_members' => $maxTeamMembers,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('settings.update'), $requestData);

        $response->assertRedirect(route('settings.edit'));
        $this->assertFalse(app('session.store')->has('errors'));
        $this->settings->refresh();
        $this->assertEquals($applicationsStart, $this->settings->applications_start_at);
        $this->assertEquals($applicationsEnd, $this->settings->applications_end_at);
        $this->assertEquals($minTeamMembers, $this->settings->min_team_members);
        $this->assertEquals($maxTeamMembers, $this->settings->max_team_members);
    }

    public function test_settings_may_not_be_updated_with_an_invalid_projects_submission_period()
    {
        $applicationsStart = Carbon::tomorrow()->addDays(3);
        $applicationsEnd = Carbon::tomorrow();
        $minTeamMembers = 1;
        $maxTeamMembers = 5;
        $requestData = [
            'applications_start_at' => $applicationsStart,
            'applications_end_at' => $applicationsEnd,
            'min_team_members' => $minTeamMembers,
            'max_team_members' => $maxTeamMembers,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('settings.update'), $requestData);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['applications_start_at', 'applications_end_at']);
        $this->assertSettingsRemainUnchanged();
    }

    public function test_settings_may_not_be_updated_with_an_invalid_team_members_range()
    {
        $applicationsStart = Carbon::tomorrow();
        $applicationsEnd = Carbon::tomorrow()->addDays(1);
        $minTeamMembers = 5;
        $maxTeamMembers = 2;
        $requestData = [
            'applications_start_at' => $applicationsStart,
            'applications_end_at' => $applicationsEnd,
            'min_team_members' => $minTeamMembers,
            'max_team_members' => $maxTeamMembers,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('settings.update'), $requestData);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['min_team_members', 'max_team_members']);
        $this->assertSettingsRemainUnchanged();
    }

    public function test_users_may_not_see_settings_form()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('settings.edit'));

        $response->assertStatus(404);
    }

    public function test_users_may_not_update_settings()
    {
        $user = factory(User::class)->create();
        $applicationsStart = Carbon::tomorrow();
        $applicationsEnd = Carbon::tomorrow()->addDays(1);
        $minTeamMembers = 5;
        $maxTeamMembers = 2;
        $requestData = [
            'applications_start_at' => $applicationsStart,
            'applications_end_at' => $applicationsEnd,
            'min_team_members' => $minTeamMembers,
            'max_team_members' => $maxTeamMembers,
        ];

        $response = $this->actingAs($user)
            ->put(route('settings.update'), $requestData);

        $response->assertStatus(404);
        $this->assertSettingsRemainUnchanged();
    }

    public function test_unauthenticated_users_may_not_update_settings()
    {
        $applicationsStart = Carbon::tomorrow();
        $applicationsEnd = Carbon::tomorrow()->addDays(1);
        $minTeamMembers = 5;
        $maxTeamMembers = 2;
        $requestData = [
            'applications_start_at' => $applicationsStart,
            'applications_end_at' => $applicationsEnd,
            'min_team_members' => $minTeamMembers,
            'max_team_members' => $maxTeamMembers,
        ];

        $response = $this->put(route('settings.update'), $requestData);

        $response->assertRedirect(route('login'));
        $this->assertSettingsRemainUnchanged();
    }

    /*
     * Assert settings remain unchanged.
     */
    protected function assertSettingsRemainUnchanged()
    {
        $actualSettings = $this->settings->fresh();
        $this->assertEquals($this->settings->applications_start_at, $actualSettings->applications_start_at);
        $this->assertEquals($this->settings->applications_end_at, $actualSettings->applications_end_at);
        $this->assertEquals($this->settings->min_team_members, $actualSettings->min_team_members);
        $this->assertEquals($this->settings->max_team_members, $actualSettings->max_team_members);
    }
}
