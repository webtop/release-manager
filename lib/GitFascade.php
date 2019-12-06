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
     * @return mixed[]
     */
    public static function getClient() {
        if (self::$client === null) {
            $buildResponse = \Library\GitClient::build(self::$instance->config);
            if ($buildResponse instanceof \Library\GitHubClient\Client\GitHubClient) {
                self::$client = $buildResponse;
                return ['success' => true, 'response' => self::$client];
            } else {
                try {
                    $json = json_decode(\Library\GitClient::$failureMessage);
                    return ['success' => false, 'response' => $json];
                } catch (\Exception $e) {
                    return ['success' => false, 'response' => $e->getMessage()];
                }
            }
        }
    }
    
    /**
     * Attempt to connect to a Git source
     * @param string $url - The base URL to connect to the source
     * @return array
     */
    private function _connect() {
        $connection = [
            'success' => false,
            'msgs' => [],
            'severity' => 'warning'
        ];
        
        $response = self::getClient();
        if ($response['success'] === true) {
            $connection['success'] = true;
            $connection['severity'] = 'info';
        } else {
            $connection['success'] = false;
            if ($response['response'] instanceof \stdClass) {
                if (property_exists($response['response'], 'documentation_url')) {
                    $connection['msgs'][] = "Error: {$response['response']->message} (see {$response['response']->documentation_url})";
                }
            }
            $connection['severity'] = 'error';
        }
        
        return $connection;
    }
    
    /**
     * Authenticate a user against a Git connection
     * 
     * @return array
     */
    private function _authenticate() {
        $connection = $this->_connect();
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