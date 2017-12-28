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
}
