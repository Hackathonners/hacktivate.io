<?php

namespace App\Rules\User;

use App\Alexa\Models\User;
use Illuminate\Contracts\Validation\Rule;

class EligibleForNewTeam implements Rule
{
    /**
     * User does not exist error type.
     *
     * @var int
     */
    const NOT_FOUND = 0;

    /**
     * User already has a team error type.
     *
     * @var int
     */
    const ALREADY_IN_A_TEAM = 1;

    /**
     * The error value.
     *
     * @var bool|int
     */
    private $error = false;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::whereGithub($value)->first();

        if (! $user) {
            $this->error = self::NOT_FOUND;
        } elseif ($user->hasTeam()) {
            $this->error = self::ALREADY_IN_A_TEAM;
        }

        return $this->error === false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $message = null;

        switch ($this->error) {
            case self::NOT_FOUND:
                $message = 'This user does not exist.';
                break;
            case self::ALREADY_IN_A_TEAM:
                $message = 'This user already has a team.';
                break;
        }

        return $message;
    }
}
