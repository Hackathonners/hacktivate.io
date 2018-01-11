<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Alexa\Models\Settings;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SettingsTest extends TestCase
{
    use DatabaseTransactions;

    public function testProjectsSubmissionPeriodIsActive()
    {
        // Prepare
        $settings = new Settings();

        // Execute
        $settings->applications_start_at = Carbon::yesterday();
        $settings->applications_end_at = Carbon::tomorrow();

        //Assert
        $this->assertTrue($settings->withinProjectsSubmissionPeriod());
    }

    public function testProjectsSubmissionPeriodIsNotActive()
    {
        // Prepare
        $settings = new Settings();

        // Execute
        $settings->applications_start_at = Carbon::tomorrow();
        $settings->applications_end_at = Carbon::tomorrow()->addDays(2);

        // Assert
        $this->assertFalse($settings->withinProjectsSubmissionPeriod());
    }

    public function testProjectsSubmissionHasExpired()
    {
        // Prepare
        $settings = new Settings();

        // Execute
        $settings->applications_start_at = Carbon::yesterday()->subDays(2);
        $settings->applications_end_at = Carbon::yesterday();

        // Assert
        $this->assertFalse($settings->withinProjectsSubmissionPeriod());
    }
}
