<?php

namespace Classes;

use Slim\Http\Request;
use Config\GitConfig;
use Library\GitFascade;

/**
 * Connection object class to connect to and handle source connection requests
 * @author Paul Allsopp <paul.allsopp@digital-pig.com>
 * @see \Singleton
 */
class Connector {
    
    private static $instance = null;
    private $connected = false;
    private $lastError = '';
    private $git;
    private $client;
    private $owner;
    
    /**
     * Instantiate class using dependency injection
     * @param GitConfig $git
     */
    private function __construct($git) {
        $this->git = $git;
        $this->owner = $this->git->getOwner();
    }
    
    /**
     * Singleton method to get instance of class
     * 
     * @param GitConfig $git
     * @return \Classes\Connector
     */
    public static function getInstance($git) {
        if (is_null(self::$instance)) {
            self::$instance = new Connector($git);
            self::$instance->connected = self::$instance->connect();
        }
        
        return self::$instance;
    }
    
    /**
     * Does what it says on the tin
     * @return string
     */
    public function getLastError() {
        return $this->lastError;
    }
    
    /**
     * Attempt to get a connection to the source
     * @return boolean
     */
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
    
    /**
     * Perform a connection test to the source
     * @param Request $request
     * @return array|boolean[]|string[]|array[]
     */
    public static function testConnection(Request $request) {
        $connectResult = [
            'success' => false,
            'severity' => 'warning',
            'msgs' => [],
            'warnings' => ''
        ];
        
        try {
            GitConfig::validateConfig($connectResult, $request);
            
            if (empty($connectResult['msgs'])) {
                $gitConfig = GitConfig::build($request);
                
                if ($gitConfig instanceof GitConfig) {
                    $connectResult = GitFascade::getInstance($gitConfig)->connect();
                    $connectResult['warnings'] = $gitConfig::$warning;
                } else {
                    $connectResult['warnings'] = $gitConfig;
                }
            }
        } catch (\Exception $e) {
            $connectResult['severity'] = 'error';
            $connectResult['msgs'][] = $e->getMessage();
        }
        
        return $connectResult;
    }
    
    /**
     * Get a list of source repositories
     * @return NULL[][]
     */
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
    
    /**
     * Get a specific repository
     * @param string $repoName
     * @return mixed
     */
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
    
    /**
     * Get a list of repo branches
     * @param string $repoName
     * @return string[]
     */
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
    
    /**
     * Get a specific branch from a repo
     * @param string $repoName
     * @param string $branchName
     * @return mixed
     */
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
