<?php
namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
use Library\GitHubClient\Client\Objects\GitHubFullIssueEvent;

class GitHubIssuesEvents extends GitHubService {

    /**
     * Attributes
     *
     * @return GitHubFullIssueEvent
     */
    public function attributes($owner, $repo, $id) {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/issues/events/$id", 'GET', $data, 200, 'GitHubFullIssueEvent');
    }
}

