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

    public function testAnAdminCanUpdateSettings()
    {
        $projectsSubmissionStart = Carbon::tomorrow();
        $projectsSubmissionEnd = Carbon::tomorrow()->addDays(1);
        $minMembersTeam = 1;
        $maxMembersTeam = 5;
        $requestData = [
            'projects_submission_start_at' => $projectsSubmissionStart,
            'projects_submission_end_at' => $projectsSubmissionEnd,
            'min_members_team' => $minMembersTeam,
            'max_members_team' => $maxMembersTeam,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('settings.update'), $requestData);

        $response->assertRedirect();
        $this->assertFalse(app('session.store')->has('errors'));
        $this->settings->refresh();
        $this->assertEquals($projectsSubmissionStart, $this->settings->projects_submission_start_at);
        $this->assertEquals($projectsSubmissionEnd, $this->settings->projects_submission_end_at);
        $this->assertEquals($minMembersTeam, $this->settings->min_members_team);
        $this->assertEquals($maxMembersTeam, $this->settings->max_members_team);
    }

    /**
     * @group failing
     */
    public function testSettingsMayNotBeUpdatedWithAnInvalidSubmittingPeriod()
    {
        $projectsSubmissionStart = Carbon::tomorrow()->addDays(3);
        $projectsSubmissionEnd = Carbon::tomorrow();
        $minMembersTeam = 1;
        $maxMembersTeam = 5;
        $requestData = [
            'projects_submission_start_at' => $projectsSubmissionStart,
            'projects_submission_end_at' => $projectsSubmissionEnd,
            'min_members_team' => $minMembersTeam,
            'max_members_team' => $maxMembersTeam,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('settings.update'), $requestData);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['projects_submission_end_at']);
        $this->assertSettingsRemainUnchanged();
    }

    public function testSettingsMayNotBeUpdatedWithAnInvalidTeamMembersRange()
    {
        $projectsSubmissionStart = Carbon::tomorrow();
        $projectsSubmissionEnd = Carbon::tomorrow()->addDays(1);
        $minMembersTeam = 5;
        $maxMembersTeam = 2;
        $requestData = [
            'projects_submission_start_at' => $projectsSubmissionStart,
            'projects_submission_end_at' => $projectsSubmissionEnd,
            'min_members_team' => $minMembersTeam,
            'max_members_team' => $maxMembersTeam,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('settings.update'), $requestData);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['min_members_team', 'max_members_team']);
        $this->assertSettingsRemainUnchanged();
    }

    public function testStudentsMayNotSeeSettingsForm()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get(route('settings.edit'));

        $response->assertStatus(404);
    }

    public function testUsersMayNotUpdateSettings()
    {
        $user = factory(User::class)->create();
        $projectsSubmissionStart = Carbon::tomorrow();
        $projectsSubmissionEnd = Carbon::tomorrow()->addDays(1);
        $minMembersTeam = 5;
        $maxMembersTeam = 2;
        $requestData = [
            'projects_submission_start_at' => $projectsSubmissionStart,
            'projects_submission_end_at' => $projectsSubmissionEnd,
            'min_members_team' => $minMembersTeam,
            'max_members_team' => $maxMembersTeam,
        ];

        $response = $this->actingAs($user)
            ->put(route('settings.update'), $requestData);

        $response->assertStatus(404);
        $this->assertSettingsRemainUnchanged();
    }

    public function testUnauthenticatedUsersMayNotUpdateSettings()
    {
        $projectsSubmissionStart = Carbon::tomorrow();
        $projectsSubmissionEnd = Carbon::tomorrow()->addDays(1);
        $minMembersTeam = 5;
        $maxMembersTeam = 2;
        $requestData = [
            'projects_submission_start_at' => $projectsSubmissionStart,
            'projects_submission_end_at' => $projectsSubmissionEnd,
            'min_members_team' => $minMembersTeam,
            'max_members_team' => $maxMembersTeam,
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
        $this->assertEquals($this->settings->projects_submission_start_at, $actualSettings->projects_submission_start_at);
        $this->assertEquals($this->settings->projects_submission_end_at, $actualSettings->projects_submission_end_at);
        $this->assertEquals($this->settings->min_members_team, $actualSettings->min_members_team);
        $this->assertEquals($this->settings->max_members_team, $actualSettings->max_members_team);
    }
}
