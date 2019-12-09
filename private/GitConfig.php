<?php

namespace Config;

use Slim\Http\Request;
use Classes\Common;

/**
 * Git configuration class used to connect to GitHub or GitLab
 * @author Paul Allsopp <paul.allsopp@digital-pig.com>
 */
class GitConfig {
    
    public static $warning = '';
    
    /**
     * Build a git configuration based on authentication type
     * 
     * @param Request $request
     * @return string|\Config\GitLabConfig|\Config\GitHubConfig
     */
    public static function build(Request $request) {
        
        if ($request->getParam('git-source-select') == Common::GITHUB_CONFIG) {
            $gitConfig = new GitHubConfig();
        } elseif ($request->getParam('git-source-select') == Common::GITLAB_CONFIG) {
            $gitConfig = new GitLabConfig();
        } else {
            // @todo Check for user-defined sources
            throw new \Exception('Unknown Git source model');
        }
        
        $gitConfig->setApiUrl($request->getParam('git-api-url'));
        
        if (empty($request->getParam('git-source-auth'))) {
            throw new \Exception('Cannot determine Git auth method');
        }
        
        $gitConfig->setAuthMethod($request->getParam('git-source-auth'));
        
        switch ($request->getParam('git-source-auth')) {
            case Common::GIT_AUTH_BASIC:
                $gitConfig->setAuthCredentials([
                    'username' => $request->getParam('git-credentials')['git-auth-username'],
                    'password' => $request->getParam('git-credentials')['git-auth-password']
                ]);
                break;
            case Common::GIT_AUTH_TOKEN:
                $gitConfig->setToken($request->getParam('git-credentials')['git-auth-token']);
                break;
            case Common::GIT_AUTH_OAUTH:
                $gitConfig->setAuthCredentials([
                    'app-id' => $request->getParam('git-credentials')['git-auth-app-id'],
                    'app-secret' => $request->getParam('git-credentials')['git-auth-secret']
                ]);
                break;
            default:
                // self::GIT_AUTH_NONE
                self::$warning = 'No auth method selected - only public projects available.';
        }
        
        return $gitConfig;
    }
    
    /**
     * Simple validation
     * 
     * @param  $connectResult
     * @param Request $request
     */
    public static function validateConfig(&$connectResult, Request $request) {
        // Note: we don't force an auth method here because not having authentication
        // is still valid for public repositories
        $requiredParameters = [
            'git-api-url' => 'No git source URL provided',
            'git-source-select' => 'No git source selected'
        ];
        
        foreach ($requiredParameters as $key => $value) {
            if (empty($request->getParam($key))) {
                $connectResult['msgs'][] = $value;
            }
        }
    }
    
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
     * 
     * @param int $authMethod
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
     * Get the Git API URL
     * 
     * @return string
     */
    public function getApiUrl() {
        return $this->urls['api'];
    }
    
    /**
     * Set the file repository URL
     * 
     * @paramstring $url
     */
    public function setFilesUrl($url) {
        $this->urls['files'] = $url;
    }
    
    /**
     * Set the API URL
     * 
     * @param string $url
     */
    public function setApiUrl($url) {
        $this->urls['api'] = $url;
    }
    
    /**
     * Get the URL used to store files
     *
     * @return string
     */
    public function getFilesUrl() {
        return $this->urls['files'];
    }
    
    /**
     * Get the repository owners name
     * 
     * @return string
     */
    public function getOwner() {
        return $this->owner;
    }
    
    /**
     * Get the OAuth key
     * 
     * @return string
     */
    public function getKey() {
        return $this->key;
    }
}

