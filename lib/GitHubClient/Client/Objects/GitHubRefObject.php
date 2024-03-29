<?php
namespace Library\GitHubClient\Client\Objects;

use Library\GitHubClient\Client\GitHubObject;

class GitHubRefObject extends GitHubObject {

    /*
     * (non-PHPdoc)
     * @see GitHubObject::getAttributes()
     */
    protected function getAttributes() {
        return array_merge(parent::getAttributes(), array(
            'type' => 'string',
            'sha' => 'string',
            'url' => 'string'
        ));
    }

    /**
     *
     * @var string
     */
    protected $type;

    /**
     *
     * @var string
     */
    protected $sha;

    /**
     *
     * @var string
     */
    protected $url;

    /**
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     *
     * @return string
     */
    public function getSha() {
        return $this->sha;
    }

    /**
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }
}

