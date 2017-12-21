<?php

namespace App\Alexa\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Get users with this role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
