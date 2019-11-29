<?php

namespace Library;


/**
 * Class: GitFascade 
 * A front-end for connection to and managing different Git sources
 * 
 * @author Paul Allsopp <pallsopp@digital-pig.com>
 * @since Nov 1, 2018
 */
class GitFascade {
   
    /**
     * Instance of Git config
     * @var \Library\GitConfig
     */
    private $config = null;
    
    /**
     * Instance of Git client framework
     * @var object 
     */
    private static $client = null;
    
    /**
     * Instance of self
     * @var \GitFascade
     */
    private static $instance;
    
    /**
     * Singleton constructor
     * 
     * @param \Library\GitConfig $config - Git config class
     * @return GitFascade
     */
    private function __construct($config) {
        $this->config = $config;
        return $this;
    }
    
    /**
     * Static method to return an instance of this fascade
     * 
     * @param \Library\GitConfig $gitConfig - Git config class
     * @return GitFascade
     */
    public static function getInstance($gitConfig) {
        if (!self::$instance instanceof GitFascade) {
            self::$instance = new GitFascade($gitConfig);
        }
        return self::$instance;
    }
    
    /**
     * Instantiate a git framework, based on the type of $this->config
     * @return \Library\GitHubClient\Client\GitHubClient|\Gitlab\Client
     */
    public static function getClient() {
        if (self::$client === null) {
            self::$client = \Library\GitClient::build(self::$instance->config);
        }
        
        return self::$client;
    }
    
    /**
     * Attempt to connect to a Git source
     * @param string $url - The base URL to connect to the source
     * @return array
     */
    private function _connect($url) {
        $connection = [
            'success' => false,
            'msgs' => [],
            'severity' => 'warning'
        ];
        
        $client = self::getClient();
        if (!empty($client::$connectionFailed) && $client::$connectionFailed === true) {
            $connection['msgs'][] = $client::$failureMessage;
            $connection['severity'] = 'error';
        } else {
            $connection['success'] = true;
            $connection['severity'] = 'info';
            $this->client = $client;
        }
        
        return $connection;
    }
    
    /**
     * Authenticate a user against a Git connection
     * 
     * @return array
     */
    private function _authenticate() {
        $connection = $this->_connect($this->config->getApiUrl());
        return $connection;
    }
    
    /**
     * Attempt to connect to a Git source, with or without authentication
     * 
     * @param bool $requiresAuth
     * @return array
     */
    public function connect() {
        return $this->_authenticate();
    }
}