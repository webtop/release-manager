<?php

namespace Config;

use Library\GitConfig;

/**
 * Implementation of GitConfig specifically for GitLab sources
 * 
 * @author Paul Allsopp <pallsopp@digital-pig.com>
 * @since Nov 1, 2018
 *
 */
class GitLabConfig implements GitConfig {
    
    /**
     * Git source URLs
     * @var array
     */
    private $urls = [
        'api' => 'http://gitlab.local/api/v4/',
        'files' => 'https://uploads.gitlab.local/'
    ];
    
    /**
     * Method of authentication
     * @var string
     */
    private $authMethod = '';
    
    /**
     * Credential for authentication method
     * @var array
     */
    private $authCredentials = [];
    
    /**
     * Git source owner
     * @var string
     */
    private  $owner = '';
    
    /**
     * Git personal access token
     * @var string
     */
    private $token = '';
    
    /**
     * Getter for URLs
     * 
     * @return the $urls
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * Getter for auth metrhod
     * 
     * @return the $authMethod
     */
    public function getAuthMethod()
    {
        return $this->authMethod;
    }

    /**
     * Getter for auth credentials
     * 
     * @return the $authCredentials
     */
    public function getAuthCredentials()
    {
        return $this->authCredentials;
    }

    /**
     * Setter for auth method
     * @param string $authMethod
     */
    public function setAuthMethod($authMethod)
    {
        $this->authMethod = $authMethod;
    }

    /**
     * Setter for auth credentials
     * 
     * @param array $authCredentials
     */
    public function setAuthCredentials($authCredentials)
    {
        $this->authCredentials = $authCredentials;
    }

    /**
     * Getter for user access token
     * 
     * @return the $token
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Setter for access URLs
     * 
     * @param array $urls
     */
    public function setUrls($urls)
    {
        $this->urls = $urls;
    }

    /**
     * Setter for repo owner
     * 
     * @param string $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * Setter for access token
     * 
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * {@inheritDoc}
     * @see \Library\GitHubClient\GitConfig::getApiUrl()
     */
    public function getApiUrl(): string {
        return $this->urls['api'];
    }
    
    /**
     * Set the file repository URL
     */
    public function setFilesUrl($url) {
        $this->urls['files'] = $url;
    }
    
    /**
     * Set the API URL
     */
    public function setApiUrl($url) {
        $this->urls['api'] = $url;
    }
    
    /**
     * {@inheritDoc}
     * @see \Library\GitHubClient\GitConfig::getFilesUrl()
     */
    public function getFilesUrl(): string {
        return $this->urls['files'];
    }
    
    /**
     * {@inheritDoc}
     * @see \Library\GitHubClient\GitConfig::getOwner()
     */
    public function getOwner(): string {
        return $this->owner;
    }
    
    
}