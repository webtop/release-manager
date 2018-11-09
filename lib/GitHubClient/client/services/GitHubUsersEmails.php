<?php
namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;

class GitHubUsersEmails extends GitHubService {

    /**
     * List email addresses for a user
     */
    public function listEmailAddressesForUser() {
        $data = array();
        
        return $this->client->request("/user/emails", 'DELETE', $data, 204, '');
    }
}

