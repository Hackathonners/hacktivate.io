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
        'applications_start_at',
        'applications_end_at',
        'min_team_members',
        'max_team_members',
        'factor_followers',
        'factor_gists',
        'factor_number_repositories',
        'factor_repository_contributions',
        'factor_repository_stars',
        'factor_repository_watchers',
        'factor_repository_forks',
        'factor_repository_size',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'applications_start_at',
        'applications_end_at',
    ];

    /**
     * Checks if applications period is set.
     *
     * @return bool
     */
    public function hasApplicationsPeriod(): bool
    {
        if (is_null($this->applications_start_at) || is_null($this->applications_end_at)) {
            return false;
        }

        return true;
    }

    /**
     * Checks whether today's date is within the applications period.
     *
     * @return bool
     */
    public function withinApplicationsPeriod(): bool
    {
        if (! $this->hasApplicationsPeriod()) {
            return false;
        }

        return $this->applications_start_at->isPast() && ! $this->applications_end_at->isPast();
    }
}
