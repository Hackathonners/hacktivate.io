<?php

namespace App\Alexa\Models;

use App\Exceptions\TeamException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * Get owner of this team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get members of this team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if the given user owns this team.
     *
     * @param  \App\Alexa\Models\User  $user
     *
     * @return bool
     */
    public function isOwner(User $user)
    {
        return $this->user_id === $user->id;
    }

    /**
     * Check if this team is eligible for acceptance.
     *
     * @return bool
     */
    public function isEligibleForAcceptance()
    {
        $currentUsersCount = $this->relationLoaded('users')
            ? $this->users->count()
            : $this->users()->count();

        return $currentUsersCount >= app('settings')->min_team_members;
    }

    /**
     * Check if this team is full.
     *
     * @return bool
     */
    public function isFull()
    {
        $currentUsersCount = $this->relationLoaded('users')
            ? $this->users->count()
            : $this->users()->count();

        return $currentUsersCount === app('settings')->max_team_members;
    }

    /**
     * Remove the given member from this team.
     *
     * @param  \App\Alexa\Models\User  $member
     *
     * @return $this
     */
    public function removeMember(User $member)
    {
        if ($member->team_id !== $this->id) {
            return $this;
        }

        $member->team()->dissociate();
        $member->save();

        // As we removed the given member from this team, we need to
        // verify if it was the last member. For this purpose, we
        // get the oldest member that might be used afterwards.
        if (($oldestMember = $this->users()->first()) == null) {
            $this->delete();

            return $this;
        }

        // Check if the member we are removing from this team is the
        // current owner of the team. If this is true a new owner
        // will be set for the team, ideally the oldest member.
        if ($this->owner->is($member)) {
            $this->owner()->associate($oldestMember);
            $this->save();
        }

        return $this;
    }

    /**
     * Add the given user to this team.
     *
     * @param  \App\Alexa\Models\User  $user
     *
     * @return bool
     */
    public function addMember(User $user)
    {
        if ($user->team_id === $this->id) {
            return true;
        }

        throw_if($this->isFull(), new TeamException('The team is full.'));

        return $this->users()->save($user);
    }
}
