<?php

namespace App\Alexa\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'projects_submission_start_at',
        'projects_submission_end_at',
        'min_members_team',
        'max_members_team',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'applications_submission_start_at',
        'applications_submission_end_at',
    ];

    /**
     * Checks whether today's date is within the submitting projects period.
     *
     * @return bool
     */
    public function withinSubmittingPeriod(): bool
    {
        if (is_null($this->projects_submission_start_at) || is_null($this->projects_submission_end_at)) {
            return false;
        }

        return $this->projects_submission_start_at->isPast() && ! $this->projects_submission_end_at->isPast();
    }
}
