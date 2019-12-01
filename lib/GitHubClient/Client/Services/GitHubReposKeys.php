<?php
namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
use Library\GitHubClient\Client\Objects\GitHubPublicKey;

class GitHubReposKeys extends GitHubService {

    /**
     * List
     *
     * @return array<GitHubPublicKey>
     */
    public function listReposKeys($owner, $repo) {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/keys", 'GET', $data, 200, 'GitHubPublicKey', true);
    }

    /**
     * Get
     *
     * @return GitHubPublicKey
     */
    public function get($owner, $repo, $id) {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/keys/$id", 'GET', $data, 200, 'GitHubPublicKey');
    }

    /**
     * Create
     *
     * @return GitHubPublicKey
     */
    public function create($owner, $repo, $id) {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/keys/$id", 'PATCH', $data, 200, 'GitHubPublicKey');
    }
}

