<?php

namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
use Library\GitHubClient\Client\Services\GitHubActivityEventsTypes;

class GitHubActivityEvents extends GitHubService
{
    
    /**
     *
     * @var GitHubActivityEventsTypes
     */
    public $types;

    /**
     * Initialize sub services
     */
    public function __construct(GitHubClient $client)
    {
        parent::__construct($client);
        
        $this->types = new GitHubActivityEventsTypes($client);
    }
}

