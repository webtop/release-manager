<?php
namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
use Library\GitHubClient\Client\Objects\GitHubHook;

class GitHubReposHooks extends GitHubService {

    /**
     * List
     *
     * @return GitHubHook
     */
    public function listReposHooks($owner, $repo, $id) {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/hooks/$id", 'GET', $data, 200, 'GitHubHook');
    }

    /**
     * Create a hook
     */
    public function createHook($owner, $repo, $id) {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/hooks/$id", 'DELETE', $data, 204, '');
    }
}

