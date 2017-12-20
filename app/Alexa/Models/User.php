<?php

namespace App\Alexa\Models;

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
        'name', 'email', 'password',
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
     * Get team who has this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ownerTeam()
    {
        return $this->hasOne(Team::class);
    }

    /**
     * Get team that this user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Check if the user is the owner of a team.
     *
     * @return bool
     */
    public function isOwner($id): bool
    {
        if (! is_null($this->ownerTeam)) {
            return $this->ownerTeam == $id;
        }

        return false;
    }
}
