<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Alexa\Models\Settings;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SettingsTest extends TestCase
{
    use DatabaseTransactions;

    public function testSubmittingPeriodIsActive()
    {
        // Prepare
        $settings = new Settings();

        // Execute
        $settings->projects_submission_start_at = Carbon::yesterday();
        $settings->projects_submission_end_at = Carbon::tomorrow();

        //Assert
        $this->assertTrue($settings->withinSubmittingPeriod());
    }

    public function testSubmittingPeriodIsNotActive()
    {
        // Prepare
        $settings = new Settings();

        // Execute
        $settings->projects_submission_start_at = Carbon::tomorrow();
        $settings->projects_submission_end_at = Carbon::tomorrow()->addDays(2);

        // Assert
        $this->assertFalse($settings->withinSubmittingPeriod());
    }

    public function testSubmittingPeriodExpired()
    {
        // Prepare
        $settings = new Settings();

        // Execute
        $settings->projects_submission_start_at = Carbon::yesterday()->subDays(2);
        $settings->projects_submission_end_at = Carbon::yesterday();

        // Assert
        $this->assertFalse($settings->withinSubmittingPeriod());
    }
}
