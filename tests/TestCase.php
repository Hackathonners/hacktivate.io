<?php

namespace Tests;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->seed();
        $this->enableApplicationsPeriod();
    }

    /*
     * Enable applications period.
     */
    protected function enableApplicationsPeriod()
    {
        $settings = app('settings');
        $settings->applications_start_at = Carbon::yesterday();
        $settings->applications_end_at = Carbon::tomorrow();
        $settings->min_team_members = 2;
        $settings->max_team_members = 4;
        $settings->save();
    }

    /*
     * Disable applications period.
     */
    protected function disableApplicationsPeriod()
    {
        $settings = app('settings');
        $settings->applications_start_at = Carbon::yesterday();
        $settings->applications_end_at = Carbon::yesterday();
        $settings->save();
    }
}
