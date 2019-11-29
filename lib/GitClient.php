<?php

namespace Library;

use Library\GitHubClient\Client\GitHubClient;
use Gitlab\Client;

/**
 * This class acts as an a client factory to produce a fully
 * configured git client, based on a GitConfig object
 * @uses \GitConfig
 * @author Paul Allsopp <paul.allsopp@digital-pig.com>
 */
class GitClient {
    
    /**
     * Instance of GitConfig
     * @var object
     */
    private static $config;
    
    /**
     * State of connection success
     * @var bool
     */
    public static $connectFailed = true;
    
    /**
     * Failure reason on failure
     * @var string
     */
    public static $failureMessage = '';
    
    /**
     * 
     * @param unknown $config
     * @return boolean|\Gitlab\Client
     */
    public static function build($config) {
        self::$config = $config;
        if ($config instanceof \Config\GitLabConfig) {
            $client = self::buildGitLabClient();
        } else {
            $client = self::buildGitHubClient();
        }
        
        if (!$client) {
            return self;
        }
        return $client;
    }
    
    /**
     * 
     * @return boolean|\Gitlab\Client
     */
    private static function buildGitLabClient() {
        $client = Client::create(self::$config->getApiUrl());
        $authMethod = '';
        switch (self::$config->getAuthMethod()) {
            case 'user_pass':
                $authMethod = $client::AUTH_URL_TOKEN;
                break;
            case 'http_token':
                $authMethod = $client::AUTH_HTTP_TOKEN;
                break;
            case 'oauth_token':
                $authMethod = $client::AUTH_OAUTH_TOKEN;
                break;
            default:
                // This should never happen because we set these, but just in case something gets mangled
                self::$failureMessage = "Unknown auth method";
                return false;
        }
        
        try {
            $client->authenticate(self::$config->getToken(), $authMethod);
            $client->__get('repo');
            self::$connectFailed = false;
        } catch (\InvalidArgumentException $e) {
            self::$failureMessage = $e->getMessage();
            return false;
        } catch (\Exception $e) {
            self::$failureMessage = $e->getMessage();
            return false;
        }
        
        return $client;
    }
    
    /**
     * 
     * @return boolean
     */
    private static function buildGitHubClient() {
        $client = new GitHubClient();
        $client->setUrl(self::$config->getApiUrl());
        switch (self::$config->getAuthMethod()) {
            case 'user_pass':
                $authMethod = $client::GITHUB_AUTH_TYPE_BASIC;
                break;
            case 'http_token':
                $authMethod = $client::GITHUB_AUTH_TYPE_OAUTH_BASIC;
                break;
            case 'oauth_token':
                $authMethod = $client::GITHUB_AUTH_TYPE_OAUTH;
                break;
            default:
                // This should never happen because we set these, but just in case something gets mangled
                self::$failureMessage = "Unknown auth method";
                return false;
        }
        
        
    }
}