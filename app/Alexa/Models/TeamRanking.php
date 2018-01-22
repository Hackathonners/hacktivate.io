<?php

namespace App\Alexa\Models;

use Illuminate\Database\Eloquent\Model;

class TeamRanking extends Model
{
    /**
     * Get team of this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function team()
    {
        return $this->hasOne(Team::class);
    }
}
