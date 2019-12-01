<?php

namespace Config;

use Config\GitConfig;

/**
 * Implementation of GitConfig specifically for GitLab sources
 * 
 * @author Paul Allsopp <pallsopp@digital-pig.com>
 * @since Nov 1, 2018
 *
 */
class GitLabConfig extends GitConfig {
    
    /**
     * Git source URLs
     * @var array
     */
    protected $urls = [
        'api' => 'http://gitlab.local/api/v4/',
        'files' => 'https://uploads.gitlab.local/'
    ];
    
    /**
     * Method of authentication
     * @var string
     */
    protected $authMethod = '';
    
    /**
     * Credential for authentication method
     * @var array
     */
    protected $authCredentials = [];
    
    /**
     * Git source owner
     * @var string
     */
    protected  $owner = '';
    
    /**
     * Git personal access token
     * @var string
     */
    protected $token = '';
    
    

}