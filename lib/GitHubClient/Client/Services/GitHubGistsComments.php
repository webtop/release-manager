<?php
namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
use Library\GitHubClient\Client\Objects\GitHubGistComment;

class GitHubGistsComments extends GitHubService {

    /**
     * List comments on a gist
     *
     * @return array<GitHubGistComment>
     */
    public function listCommentsOnGist($gist_id) {
        $data = array();
        
        return $this->client->request("/gists/$gist_id/comments", 'GET', $data, 200, 'GitHubGistComment', true);
    }

    /**
     * Get a single comment
     *
     * @return GitHubGistComment
     */
    public function getSingleComment($gist_id, $id) {
        $data = array();
        
        return $this->client->request("/gists/$gist_id/comments/$id", 'GET', $data, 200, 'GitHubGistComment');
    }

    /**
     * Create a comment
     *
     * @return GitHubGistComment
     */
    public function createComment($gist_id, $id) {
        $data = array();
        
        return $this->client->request("/gists/$gist_id/comments/$id", 'PATCH', $data, 200, 'GitHubGistComment');
    }

    /**
     * Delete a comment
     */
    public function deleteComment($gist_id, $id) {
        $data = array();
        
        return $this->client->request("/gists/$gist_id/comments/$id", 'DELETE', $data, 204, '');
    }
}

