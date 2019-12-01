<?php
namespace Library\GitHubClient\Client\Objects;

use Library\GitHubClient\Client\GitHubObject;

class GitHubPublicKey extends GitHubObject {

    /*
     * (non-PHPdoc)
     * @see GitHubObject::getAttributes()
     */
    protected function getAttributes() {
        return array_merge(parent::getAttributes(), array(
            'url' => 'string',
            'title' => 'string'
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
    protected $title;

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
    public function getTitle() {
        return $this->title;
    }
}

