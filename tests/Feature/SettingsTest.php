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
        $projectsSubmissionStart = Carbon::tomorrow();
        $projectsSubmissionEnd = Carbon::tomorrow()->addDays(1);
        $minMembersTeam = 1;
        $maxMembersTeam = 5;
        $requestData = [
            'applications_start_at' => $projectsSubmissionStart,
            'applications_end_at' => $projectsSubmissionEnd,
            'min_team_members' => $minMembersTeam,
            'max_team_members' => $maxMembersTeam,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('settings.update'), $requestData);

        $response->assertRedirect(route('settings.edit'));
        $this->assertFalse(app('session.store')->has('errors'));
        $this->settings->refresh();
        $this->assertEquals($projectsSubmissionStart, $this->settings->applications_start_at);
        $this->assertEquals($projectsSubmissionEnd, $this->settings->applications_end_at);
        $this->assertEquals($minMembersTeam, $this->settings->min_team_members);
        $this->assertEquals($maxMembersTeam, $this->settings->max_team_members);
    }

    public function test_settings_may_not_be_updated_with_an_invalid_projects_submission_period()
    {
        $projectsSubmissionStart = Carbon::tomorrow()->addDays(3);
        $projectsSubmissionEnd = Carbon::tomorrow();
        $minMembersTeam = 1;
        $maxMembersTeam = 5;
        $requestData = [
            'applications_start_at' => $projectsSubmissionStart,
            'applications_end_at' => $projectsSubmissionEnd,
            'min_team_members' => $minMembersTeam,
            'max_team_members' => $maxMembersTeam,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('settings.update'), $requestData);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['applications_start_at', 'applications_end_at']);
        $this->assertSettingsRemainUnchanged();
    }

    public function test_settings_may_not_be_updated_with_an_invalid_team_members_range()
    {
        $projectsSubmissionStart = Carbon::tomorrow();
        $projectsSubmissionEnd = Carbon::tomorrow()->addDays(1);
        $minMembersTeam = 5;
        $maxMembersTeam = 2;
        $requestData = [
            'applications_start_at' => $projectsSubmissionStart,
            'applications_end_at' => $projectsSubmissionEnd,
            'min_team_members' => $minMembersTeam,
            'max_team_members' => $maxMembersTeam,
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
        $projectsSubmissionStart = Carbon::tomorrow();
        $projectsSubmissionEnd = Carbon::tomorrow()->addDays(1);
        $minMembersTeam = 5;
        $maxMembersTeam = 2;
        $requestData = [
            'applications_start_at' => $projectsSubmissionStart,
            'applications_end_at' => $projectsSubmissionEnd,
            'min_team_members' => $minMembersTeam,
            'max_team_members' => $maxMembersTeam,
        ];

        $response = $this->actingAs($user)
            ->put(route('settings.update'), $requestData);

        $response->assertStatus(404);
        $this->assertSettingsRemainUnchanged();
    }

    public function test_unauthenticated_users_may_not_update_settings()
    {
        $projectsSubmissionStart = Carbon::tomorrow();
        $projectsSubmissionEnd = Carbon::tomorrow()->addDays(1);
        $minMembersTeam = 5;
        $maxMembersTeam = 2;
        $requestData = [
            'applications_start_at' => $projectsSubmissionStart,
            'applications_end_at' => $projectsSubmissionEnd,
            'min_team_members' => $minMembersTeam,
            'max_team_members' => $maxMembersTeam,
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
