<?php
namespace Library\GitHubClient\Client\Objects;

use Library\GitHubClient\Client\GitHubObject;

class GitHubRepoSubscription extends GitHubObject {

    /*
     * (non-PHPdoc)
     * @see GitHubObject::getAttributes()
     */
    protected function getAttributes() {
        return array_merge(parent::getAttributes(), array(
            'url' => 'string',
            'repository_url' => 'string'
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
    protected $repository_url;

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
    public function getRepositoryUrl() {
        return $this->repository_url;
    }
}

