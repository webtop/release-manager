<?php
namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
use Library\GitHubClient\Client\Services\GitHubGitBlobs;
use Library\GitHubClient\Client\Services\GitHubGitCommits;
use Library\GitHubClient\Client\Services\GitHubGitImport;
use Library\GitHubClient\Client\Services\GitHubGitRefs;
use Library\GitHubClient\Client\Services\GitHubGitTags;
use Library\GitHubClient\Client\Services\GitHubGitTrees;

class GitHubGit extends GitHubService {

    /**
     *
     * @var GitHubGitBlobs
     */
    public $blobs;

    /**
     *
     * @var GitHubGitCommits
     */
    public $commits;

    /**
     *
     * @var GitHubGitImport
     */
    public $import;

    /**
     *
     * @var GitHubGitRefs
     */
    public $refs;

    /**
     *
     * @var GitHubGitTags
     */
    public $tags;

    /**
     *
     * @var GitHubGitTrees
     */
    public $trees;

    /**
     * Initialize sub services
     */
    public function __construct(GitHubClient $client) {
        parent::__construct($client);
        
        $this->blobs = new GitHubGitBlobs($client);
        $this->commits = new GitHubGitCommits($client);
        $this->import = new GitHubGitImport($client);
        $this->refs = new GitHubGitRefs($client);
        $this->tags = new GitHubGitTags($client);
        $this->trees = new GitHubGitTrees($client);
    }
}

