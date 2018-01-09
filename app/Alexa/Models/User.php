<?php

namespace App\Alexa\Models;

use Illuminate\Support\Arr;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'github', 'location',
        'phone_number', 'gender', 'birthdate', 'dietary_restrictions', 'school',
        'major', 'study_level', 'special_needs', 'bio',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     *
     * @return bool
     */
    public function save(array $options = [])
    {
        if (is_null($this->role)) {
            $userRole = Role::whereType(Role::ROLE_USER)->first();
            $this->role()->associate($userRole);
        }

        return parent::save($options);
    }

    /**
     * Get team of this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get role of this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get owned team of this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ownerTeam()
    {
        return $this->hasOne(Team::class);
    }

    /**
     * Check if this user has a complete profile.
     *
     * @return bool
     */
    public function hasCompleteProfile()
    {
        $optional = ['dietary_restrictions', 'special_needs'];

        $attributes = array_diff($this->fillable, $optional);

        $filledAttributes = array_filter(Arr::only($this->attributes, $attributes));

        return count($attributes) === count($filledAttributes);
    }

    /**
     * Check if this user has a team.
     *
     * @return bool
     */
    public function hasTeam()
    {
        return $this->team_id != null;
    }

    /**
     * Check if this user has an eligible team.
     *
     * @return bool
     */
    public function hasEligibleTeam()
    {
        return $this->hasTeam() && $this->team->isEligibleForAcceptance();
    }

    /**
     * Check if this user completed the application.
     *
     * @return bool
     */
    public function hasCompleteApplication()
    {
        return $this->hasCompleteProfile() && $this->hasEligibleTeam();
    }

    /**
     * Scope a query to only include users that match given search.
     *
     * @param  $query  \Illuminate\Database\Eloquent\Builder
     * @param  string|null  $search
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterByEmailOrNickname($query, $search)
    {
        if ($search === null) {
            return $query;
        }

        return $query->where('email', 'ILIKE', $search.'%')
            ->orWhere('github', 'ILIKE', $search.'%');
    }

    /**
     * Scope a query to only include users that do not have a team.
     *
     * @param  $query  \Illuminate\Database\Eloquent\Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutTeam($query)
    {
        return $query->whereNull('team_id');
    }

    /**
     * Leave the current team.
     *
     * @return $this
     */
    public function leaveCurrentTeam()
    {
        if ($this->hasTeam()) {
            $this->team->removeMember($this);
        }

        return $this;
    }
}
