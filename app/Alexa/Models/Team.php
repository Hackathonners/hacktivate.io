<?php

namespace App\Alexa\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
  /**
   * The relations to eager load on every query.
   *
   * @var array
   */
   protected $with = ['team_name','project_name'];

   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = ['bio'];

   /**
    * Get user who owns this team.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function owner() {
     return $this->belongsTo(User::class);
   }

   /**
    * Get users who are on this team.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function users() {
     return $this->hasMany(User::class);
   }
}
