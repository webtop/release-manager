<?php

namespace Config;

use Library\GitHubClient\GitConfig;

class GitLabConfig implements GitConfig {
    
    /**
     * Git source URLs
     * @var array
     */
    private $urls = [
        'api' => 'http://gitlab.test:8000/',
        'files' => 'https://uploads.gitlab.test:8000'
    ];
    
    /**
     * Git source owner
     * @var string
     */
    private  $owner = 'webtop';
    
    /**
     * Git personal access token
     * @var string
     */
    private $token = 'Zx_bTbKdctDgbdANJ8P4';
    
    /**
     * {@inheritDoc}
     * @see \Library\GitHubClient\GitConfig::getApiUrl()
     */
    public function getApiUrl() {
        
    }
    
    /**
     * {@inheritDoc}
     * @see \Library\GitHubClient\GitConfig::getFilesUrl()
     */
    public function getFilesUrl() {
        
    }
    
    /**
     * {@inheritDoc}
     * @see \Library\GitHubClient\GitConfig::getOwner()
     */
    public function getOwner() {
        
    }
    
    /**
     * {@inheritDoc}
     * @see \Library\GitHubClient\GitConfig::getAccessToken()
     */
    public function getAccessToken() {
        
    }
}