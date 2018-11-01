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
            'msg' => ''
        ];
        
        try {
            $this->client = \Gitlab\Client::create($this->config->getApiUrl());
            $this->client->api('version');
            $connection['success'] = true;
        } catch (\Exception $e) {
            $connection['msg'] = $e->getMessage();
        }
        
        return $connection;
    }
    
    /**
     * Authenticate a user access token against a Git connection
     * 
     * @return array
     */
    private function _authenticate() {
        $connection = $this->_connect($this->config->getApiUrl(), true);
        
        if ($connection['success']) {
            try {
                $this->client->authenticate($this->config->getToken(), $this->config->getAuthMethod());
            } catch (\Exception $e) {
                $connection['success'] = false;
                $connection['msg'] = $e->getMessage();
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
    public function connect($requiresAuth = false) {
        if ($requiresAuth) {
            $connection = $this->_authenticate();
        } else {
            $connection = $this->_connect(true);
        }
        
        return $connection;
    }
}