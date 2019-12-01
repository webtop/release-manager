<?php

namespace Config;

use Config\GitConfig;

/**
 * Implementation of GitConfig specifically for GitHub
 * @author Paul Allsopp <paul.allsopp@digital-pig.com>
 */
class GitHubConfig extends GitConfig {
    /**
     * Git source URLs
     * @var array
     */
    protected $urls = [
        'api' => 'https://api.github.com',
        'files' => 'https://uploads.github.com'
    ];
    
    /**
     * Git source owner
     * @var string
     */
    protected  $owner = '';
    
    /**
     * Git OAuth key
     * @var string
     */
    protected $key = '';
    
    /**
     * Git personal access token
     * @var string
     */
    protected $token = '';
    
    /**
     * Credential for authentication method
     * @var array
     */
    protected $authCredentials = [];

}
