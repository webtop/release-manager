<?php

namespace Library\GitHubClient\Client;

use Library\GitHubClient\Client\GitHubClientBase;
use Library\GitHubClient\Client\Services\GitHubActivity;
use Library\GitHubClient\Client\Services\GitHubChangelog;
use Library\GitHubClient\Client\Services\GitHubGists;
use Library\GitHubClient\Client\Services\GitHubGit;
use Library\GitHubClient\Client\Services\GitHubGitignore;
use Library\GitHubClient\Client\Services\GitHubIssues;
use Library\GitHubClient\Client\Services\GitHubLibraries;
use Library\GitHubClient\Client\Services\GitHubMarkdown;
use Library\GitHubClient\Client\Services\GitHubMedia;
use Library\GitHubClient\Client\Services\GitHubMeta;
use Library\GitHubClient\Client\Services\GitHubOauth;
use Library\GitHubClient\Client\Services\GitHubOrgs;
use Library\GitHubClient\Client\Services\GitHubPulls;
use Library\GitHubClient\Client\Services\GitHubRepos;
use Library\GitHubClient\Client\Services\GitHubSearch;
use Library\GitHubClient\Client\Services\GitHubUsers;

class GitHubClient extends GitHubClientBase
{
    
    /**
     *
     * @var GitHubActivity
     */
    public $activity;
    
    /**
     *
     * @var GitHubChangelog
     */
    public $changelog;
    
    /**
     *
     * @var GitHubGists
     */
    public $gists;
    
    /**
     *
     * @var GitHubGit
     */
    public $git;
    
    /**
     *
     * @var GitHubGitignore
     */
    public $gitignore;
    
    /**
     *
     * @var GitHubIssues
     */
    public $issues;
    
    /**
     *
     * @var GitHubLibraries
     */
    public $libraries;
    
    /**
     *
     * @var GitHubMarkdown
     */
    public $markdown;
    
    /**
     *
     * @var GitHubMedia
     */
    public $media;
    
    /**
     *
     * @var GitHubMeta
     */
    public $meta;
    
    /**
     *
     * @var GitHubOauth
     */
    public $oauth;
    
    /**
     *
     * @var GitHubOrgs
     */
    public $orgs;
    
    /**
     *
     * @var GitHubPulls
     */
    public $pulls;
    
    /**
     *
     * @var GitHubRepos
     */
    public $repos;
    
    /**
     *
     * @var GitHubSearch
     */
    public $search;
    
    /**
     *
     * @var GitHubUsers
     */
    public $users;

    /**
     * Initialize sub services
     */
    public function __construct()
    {
        $this->activity = new GitHubActivity($this);
        $this->changelog = new GitHubChangelog($this);
        $this->gists = new GitHubGists($this);
        $this->git = new GitHubGit($this);
        $this->gitignore = new GitHubGitignore($this);
        $this->issues = new GitHubIssues($this);
        $this->libraries = new GitHubLibraries($this);
        $this->markdown = new GitHubMarkdown($this);
        $this->media = new GitHubMedia($this);
        $this->meta = new GitHubMeta($this);
        $this->oauth = new GitHubOauth($this);
        $this->orgs = new GitHubOrgs($this);
        $this->pulls = new GitHubPulls($this);
        $this->repos = new GitHubRepos($this);
        $this->search = new GitHubSearch($this);
        $this->users = new GitHubUsers($this);
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }
}

