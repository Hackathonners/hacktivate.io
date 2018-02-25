<?php

namespace App\Exceptions;

use Exception;

class GithubHandlerException extends Exception
{
    /**
     * The invalid github handler.
     *
     * @var string
     */
    protected $githubHandler;

    /**
     * Create a new exception instance.
     *
     * @param string $github
     * @param string                        $message
     */
    public function __construct(string $githubHandler = '', $message = 'The given github handler is not valid.')
    {
        parent::__construct($message);
        $this->githubHandler = $githubHandler;
    }

    /**
     * Get the github handler of this exception.
     *
     * @return string
     */
    public function getGithubHandler()
    {
        return $this->githubHandler;
    }
}
