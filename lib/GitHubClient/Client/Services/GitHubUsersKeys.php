<?php
namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
use Library\GitHubClient\Client\Objects\GitHubSimplePublicKey;
use Library\GitHubClient\Client\Objects\GitHubPublicKey;

class GitHubUsersKeys extends GitHubService {

    /**
     * List public keys for a user
     *
     * @return array<GitHubSimplePublicKey>
     */
    public function listPublicKeysForUser($user) {
        $data = array();
        
        return $this->client->request("/users/$user/keys", 'GET', $data, 200, 'GitHubSimplePublicKey', true);
    }

    /**
     * List your public keys
     *
     * @return array<GitHubPublicKey>
     */
    public function listYourPublicKeys() {
        $data = array();
        
        return $this->client->request("/user/keys", 'GET', $data, 200, 'GitHubPublicKey', true);
    }

    /**
     * Get a single public key
     *
     * @return GitHubPublicKey
     */
    public function getSinglePublicKey($id) {
        $data = array();
        
        return $this->client->request("/user/keys/$id", 'GET', $data, 200, 'GitHubPublicKey');
    }

    /**
     * Create a public key
     *
     * @return GitHubPublicKey
     */
    public function createPublicKey($id) {
        $data = array();
        
        return $this->client->request("/user/keys/$id", 'PATCH', $data, 200, 'GitHubPublicKey');
    }
}

