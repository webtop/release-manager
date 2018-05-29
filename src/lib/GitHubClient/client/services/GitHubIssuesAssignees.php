<?php

namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
use Library\GitHubClient\Client\Objects\GitHubUser;

class GitHubIssuesAssignees extends GitHubService
{

    /**
     * List assignees
     *
     * @return array<GitHubUser>
     */
    public function listAssignees($owner, $repo)
    {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/assignees", 'GET', $data, 200, 'GitHubUser', true);
    }
}

