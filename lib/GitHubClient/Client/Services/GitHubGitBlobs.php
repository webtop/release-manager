<?php
namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
use Library\GitHubClient\Client\Objects\GitHubBlob;

class GitHubGitBlobs extends GitHubService {

    /**
     * Get a Blob
     *
     * @return array<GitHubBlob>
     */
    public function getBlob($owner, $repo, $sha) {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/git/blobs/$sha", 'GET', $data, 200, 'GitHubBlob', true);
    }
}

