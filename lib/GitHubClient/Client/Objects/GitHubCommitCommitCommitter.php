<?php
namespace Library\GitHubClient\Client\Objects;

use Library\GitHubClient\Client\GitHubObject;

class GitHubCommitCommitCommitter extends GitHubObject {

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $date;

    /**
     *
     * @var string
     */
    protected $email;

    /**
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     *
     * @return string
     */
    public function getDate() {
        return $this->date;
    }

    /**
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /*
     * (non-PHPdoc)
     * @see GitHubObject::getAttributes()
     */
    protected function getAttributes() {
        return array_merge(parent::getAttributes(), [
            'name' => 'string',
            'date' => 'string',
            'email' => 'string'
        ]);
    }
}

