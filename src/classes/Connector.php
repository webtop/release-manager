<?php

namespace Classes;

use Slim\Http\Request;
use Config\GitConfig;
use Library\GitFascade;

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
            $this->client = $this->git->connect();
            $success = true;
        } catch (\Exception $e) {
            $this->lastError = $e->getMessage();
        }
        return $success;
    }
    
    public static function testConnection(Request $request) {
        $connectResult = [
            'success' => false,
            'severity' => 'error',
            'msgs' => [],
            'warnings' => ''
        ];
        
        GitConfig::validateConfig($connectResult, $request);
        
        if (empty($connectResult['msgs'])) {
            $gitConfig = GitConfig::build($request);
            
            $connectResult = GitFascade::getInstance($gitConfig)->connect();
            $connectResult['warnings'] = $gitConfig::$warning;
        }
        
        return $connectResult;
    }
    
    public function getRepos() {
        $repos = [];
        $objects = $this->client->repos->listYourRepositories();
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