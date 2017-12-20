<?php

namespace App;

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
        'name', 'github_handle', 'phone_number', 'genre', 'shirt_size', 'birthdate',
        'dietary_restrictions', 'school', 'major', 'study_level', 'special_needs',
        'bio', 'email', 'password',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function team()
    {
        return $this->hasOne(Team::class);
    }

    /**
     * Get role of this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne(Role::class);
    }

    /**
     * Get owned team of this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ownedTeam()
    {
        return $this->hasOne(Team::class);
    }
}
