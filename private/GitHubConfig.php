<?php

namespace Config;

use Config\GitConfig;


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
    protected  $owner = 'webtop';
    
    /**
     * Git personal access token
     * @var string
     */
    protected $token = 'a0d2c8fe406811eabf1fab2cc7e4ed5798532b69';

}
