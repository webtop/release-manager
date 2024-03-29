<?php
namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
use Library\GitHubClient\Client\Objects\GitHubMilestone;

class GitHubIssuesMilestones extends GitHubService {

    /**
     * List milestones for a repository
     *
     * @return array<GitHubMilestone>
     */
    public function listMilestonesForRepository($owner, $repo) {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/milestones", 'GET', $data, 200, 'GitHubMilestone', true);
    }

    /**
     * Get a single milestone
     *
     * @return GitHubMilestone
     */
    public function getSingleMilestone($owner, $repo, $number) {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/milestones/$number", 'GET', $data, 200, 'GitHubMilestone');
    }

    /**
     * Create a milestone
     *
     * @param $description (Optional)
     *            - A description of the milestone.
     * @param $state string
     *            (Optional) - `open` or `closed`. Default is `open`.
     * @param $due_on string
     *            (Optional) - ISO 8601 time.
     * @return GitHubMilestone
     */
    public function createMilestone($owner, $repo, $title, $description = null, $state = null, $due_on = null) {
        $data = array();
        $data['title'] = $title;
        if (!is_null($description))
            $data['description'] = $description;
        if (!is_null($state))
            $data['state'] = $state;
        if (!is_null($due_on))
            $data['due_on'] = $due_on;
        
        return $this->client->request("/repos/$owner/$repo/milestones", 'POST', json_encode($data), 201, 'GitHubMilestone');
    }

    /**
     * Update a milestone
     *
     * @param $description (Optional)
     *            - A description of the milestone.
     * @param $state string
     *            (Optional) - `open` or `closed`. Default is `open`.
     * @param $due_on string
     *            (Optional) - ISO 8601 time.
     * @return GitHubMilestone
     */
    public function updateMilestone($owner, $repo, $number, $title = null, $description = null, $state = null, $due_on = null) {
        $data = array();
        if (!is_null($title))
            $data['title'] = $title;
        if (!is_null($description))
            $data['description'] = $description;
        if (!is_null($state))
            $data['state'] = $state;
        if (!is_null($due_on))
            $data['due_on'] = $due_on;
        
        return $this->client->request("/repos/$owner/$repo/milestones/$number", 'PATCH', json_encode($data), 200, 'GitHubMilestone');
    }

    /**
     * Delete a milestone
     */
    public function deleteMilestone($owner, $repo, $number) {
        $data = array();
        
        return $this->client->request("/repos/$owner/$repo/milestones/$number", 'DELETE', $data, 204, '');
    }
}

