<?php
namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
use Library\GitHubClient\Client\Objects\GitHubRepoSubscription;

class GitHubActivityWatching extends GitHubService {

    /**
     * List watchers
     *
     * @return GitHubRepoSubscription
     */
    public function listWatchers($owner, $repo) {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/subscription", 'GET', $data, 200, 'GitHubRepoSubscription');
    }

    /**
     * Set a Repository Subscription
     *
     * @return GitHubRepoSubscription
     */
    public function setRepositorySubscription($owner, $repo) {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/subscription", 'PUT', $data, 200, 'GitHubRepoSubscription');
    }

    /**
     * Delete a Repository Subscription
     */
    public function deleteRepositorySubscription($owner, $repo) {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/subscription", 'DELETE', $data, 204, '');
    }

    /**
     * Check if you are watching a repository (LEGACY)
     */
    public function checkIfYouAreWatchingRepositoryLegacy($owner, $repo) {
        $data = array();
        
        return $this->client->request("/user/subscriptions/$owner/$repo", 'PUT', $data, 204, '');
    }
}

