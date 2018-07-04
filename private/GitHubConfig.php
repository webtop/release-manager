<?php

namespace Config;

use Library\GitHubClient\GitConfig;

class GitHubConfig implements GitConfig {
    /**
     * Git source URLs
     * @var array
     */
    private $urls = [
        'api' => 'https://api.github.com',
        'files' => 'https://uploads.github.com'
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
    private $token = 'a0d2c8fe406811eabf1fab2cc7e4ed5798532b69';
        
    /**
    * {@inheritDoc}
    * @see GitConfig::getApiUrl()
    */
    public function getApiUrl():string {
        return $this->urls['api'];
    }
    
    /**
    * {@inheritDoc}
    * @see GitConfig::getDownloadUrl()
    */
    public function getFilesUrl():string {
        return $this->urls['files'];
    }
    
    /**
    * {@inheritDoc}
    * @see GitConfig::getOwner()
    */
    public function getOwner():string {
        return $this->owner;
    }
    
    /**
    * {@inheritDoc}
    * @see GitConfig::getAccessToken()
    */
    public function getAccessToken():string {
        return $this->token;
    }
}
