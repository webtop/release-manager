<?php

namespace Library;

use Gitlab\Client;

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
    private $client = null;
    
    /**
     * Instance of self
     * @var \GitFascade
     */
    private static $instance;
    
    /**
     * Singleton constructor
     * 
     * @param \Library\GitConfig $config
     * @return GitFascade
     */
    private function __construct($config) {
        $this->config = $config;
        return $this;
    }
    
    /**
     * Static method to return an instance of this fascade
     * 
     * @param \Library\GitConfig $gitConfig
     * @return GitFascade
     */
    public static function getInstance($gitConfig) {
        if (!self::$instance instanceof GitFascade) {
            self::$instance = new GitFascade($gitConfig);
        }
        return self::$instance;
    }
    
    /**
     * Attempt to connect to a Git source
     * 
     * @return array
     */
    private function _connect() {
        $connection = [
            'success' => false,
            'msgs' => [],
            'severity' => 'warning'
        ];
        
        try {
            $this->client = Client::create($this->config->getApiUrl());
            $connection['success'] = true;
            $connection['severity'] = '';
        } catch (\Exception $e) {
            $connection['severity'] = 'error';
            $connection['msgs'][] = $e->getMessage();
        }
        
        return $connection;
    }
    
    /**
     * Authenticate a user against a Git connection
     * 
     * @return array
     */
    private function _authenticate() {
        $connection = $this->_connect($this->config->getApiUrl(), true);
        
        if ($connection['success']) {
            try {
                $connectionBuilder = $this->client->authenticate($this->config->getToken(), $this->config->getAuthMethod());
                $connectionBuilder->version()->show();
            } catch (\Exception $e) {
                if ($e->getCode() == 401) {
                    $connection['success'] = false;
                    $connection['severity'] = 'warning';
                } else {
                    $connection['success'] = false;
                    $connection['severity'] = 'error';
                    $connection['msgs'][] = $e->getMessage();
                }
            }
        }
        
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