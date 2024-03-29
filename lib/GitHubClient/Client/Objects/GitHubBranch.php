<?php
namespace Library\GitHubClient\Client\Objects;

use Library\GitHubClient\Client\GitHubObject;

class GitHubBranch extends GitHubObject {

    /*
     * (non-PHPdoc)
     * @see GitHubObject::getAttributes()
     */
    protected function getAttributes() {
        return array_merge(parent::getAttributes(), array(
            'name' => 'string',
            'commit' => 'GitHubCommit'
        ));
    }

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var GitHubGitCommit
     */
    protected $commit;

    /**
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     *
     * @return GitHubGitCommit
     */
    public function getCommit() {
        return $this->commit;
    }
}

