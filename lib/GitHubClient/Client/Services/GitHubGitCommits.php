<?php
namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
use Library\GitHubClient\Client\Objects\GitHubGitCommit;

class GitHubGitCommits extends GitHubService {

    /**
     * Get a Commit
     *
     * @return GitHubGitCommit
     */
    public function getCommit($owner, $repo, $sha) {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/git/commits/$sha", 'GET', $data, 200, 'GitHubGitCommit');
    }
}

