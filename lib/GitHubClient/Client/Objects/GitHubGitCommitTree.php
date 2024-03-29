<?php
namespace Library\GitHubClient\Client\Objects;

use Library\GitHubClient\Client\GitHubObject;

class GitHubGitCommitTree extends GitHubObject {

    /*
     * (non-PHPdoc)
     * @see GitHubObject::getAttributes()
     */
    protected function getAttributes() {
        return array_merge(parent::getAttributes(), array(
            'url' => 'string',
            'sha' => 'string'
        ));
    }

    /**
     *
     * @var string
     */
    protected $url;

    /**
     *
     * @var string
     */
    protected $sha;

    /**
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     *
     * @return string
     */
    public function getSha() {
        return $this->sha;
    }
}

