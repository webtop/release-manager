<?php

namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
use Library\GitHubClient\Client\Objects\GitHubRepo;

class GitHubReposForks extends GitHubService
{

    /**
     * List forks
     *
     * @return array<GitHubRepo>
     */
    public function listForks($owner, $repo)
    {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/forks", 'GET', $data, 200, 'GitHubRepo', true);
    }
}

