<?php

namespace DigitalPig\ReleaseManager;

use DigitalPig\ReleaseManager\Common;

class Connector {
    
    private static $instance = null;
    private $connected = false;
    private $lastError = '';
    private $config;
    private $client;
    private $owner;
    
    private function __construct($config) {
        $this->config = $config;
        $this->owner = $this->config['github']['owner'];
    }
    
    public static function getInstance($config = '') {
        if (is_null(self::$instance)) {
            if (empty($config)) {
                throw new \Exception('Must have configuration for new instances');
            }
            self::$instance = new Connector($config);
            self::$instance->connected = self::$instance->connect();
        }
        
        return self::$instance;
    }
    
    public function getLastError() {
        return $this->lastError;
    }
    
    private function connect() {
        $success = false;
        try {
            $this->client = new \GitHubClient();
            $this->client->setAuthType(\GitHubClientBase::GITHUB_AUTH_TYPE_OAUTH_BASIC);
            $this->client->setOauthKey($this->config['github']['token']);
            $success = true;
        } catch (\GitHubClientException $e) {
            $this->lastError = $e->getMessage();
        }
        return $success;
    }
    
    public function getRepos() {
        $repos = [];
        $objects = $this->client->repos->listUserRepositories($this->owner, 'owner');
        foreach ($objects as $repo) {
            $repos[$repo->getId()] = [
                'name' => $repo->getName(),
                'full_name' => $repo->getFullName(),
                'description' => $repo->getDescription()
            ];
        }
        return $repos;
    }
    
    public function getRepo($repoName) {
        $repo = $this->client->repos->get($this->owner, $repoName);
        $master = $this->client->repos->getBranch($this->owner, $repoName, 'master');
        $size = $repo->getSize();
        $lastPushed = $repo->getPushedAt();
        
        return [
            'full_name' => $repo->getFullName(),
            'master' => $master->getCommit(),
            'size' => $size,
            'last_pushed' => $lastPushed
        ];
    }
    
    public function getBranches($repoName) {
        $branches = [];
        $objects = $this->client->repos->listBranches($this->owner, $repoName);
        foreach ($objects as $branch) {
            $branches[] = [
                'name' => $branch->getName()
            ];
        }
        return $branches;
    }
    
    public function getBranch($repoName, $branchName) {
        $properties = $this->client->repos->getBranch($this->owner, $repoName, $branchName);
        $lastCommit = $properties->getCommit()->getCommit();
        $branch = [
            'name' => $properties->getName(),
            'last_commit_author' => [
                'name' => $lastCommit->getCommitter()->getName(),
                'email' => $lastCommit->getCommitter()->getEmail(),
                'date' => $lastCommit->getCommitter()->getDate()
            ],
            'last_commit_msg' => $lastCommit->getMessage()
        ];
        
        return $branch;
    }
}