<?php

namespace App\Alexa\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Administrator role type.
     *
     * @var string
     */
    const ROLE_ADMINISTRATOR = 'admin';
    const ROLE_USER = 'user';

    /**
     * Indicates if model should be timestamped.
     *
     * @var bool
     */
    public $timetamps = false;

    /**
     * Get users with this role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if this entity role is of admin type.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->type === self::ROLE_ADMINISTRATOR;
    }

    /**
     * Check if this entity role is of user type.
     *
     * @return bool
     */
    public function isUser()
    {
        return $this->type === self::ROLE_USER;
    }
}
