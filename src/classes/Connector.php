<?php

namespace Classes;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubClientBase;
use Library\GitHubClient\Client\GitHubClientException;

class Connector {
    
    private static $instance = null;
    private $connected = false;
    private $lastError = '';
    private $git;
    private $client;
    private $owner;
    
    private function __construct($git) {
        $this->git = $git;
        $this->owner = $this->git->getOwner();
    }
    
    public static function getInstance($git) {
        if (is_null(self::$instance)) {
            self::$instance = new Connector($git);
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
            $this->client = new GitHubClient();
            $this->client->setUrl($this->git->getApiUrl());
            $this->client->setAuthType(GitHubClientBase::GITHUB_AUTH_TYPE_OAUTH_BASIC);
            $this->client->setOauthKey($this->git->getAccessToken());
            $success = true;
        } catch (GitHubClientException $e) {
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