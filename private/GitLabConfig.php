<?php

namespace Config;

use Library\GitHubClient\GitConfig;


class GitLabConfig implements GitConfig {
    
    /**
     * Git source URLs
     * @var array
     */
    private $urls = [
        'api' => 'http://gitlab.local/',
        'files' => 'https://uploads.gitlab.local'
    ];
    
    /**
     * Git source owner
     * @var string
     */
    private  $owner = 'paul.allsopp';
    
    /**
     * Git personal access token
     * @var string
     */
    private $token = 'bzBUYv5Ay2YCrDZ3GuBn';
    
    /**
     * {@inheritDoc}
     * @see \Library\GitHubClient\GitConfig::getApiUrl()
     */
    public function getApiUrl() {
        return $this->urls['api'];
    }
    
    /**
     * {@inheritDoc}
     * @see \Library\GitHubClient\GitConfig::getFilesUrl()
     */
    public function getFilesUrl() {
        return $this->urls['files'];
    }
    
    /**
     * {@inheritDoc}
     * @see \Library\GitHubClient\GitConfig::getOwner()
     */
    public function getOwner() {
        return $this->owner;
    }
    
    public function connect() {
        try {
            $client = \Gitlab\Client::create($this->urls['api'])
                ->authenticate($this->token, \Gitlab\Client::AUTH_URL_TOKEN);
        } catch (\Exception $e) {
            $client = false;
            
        }
        return $client;
    }
}