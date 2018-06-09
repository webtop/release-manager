<?php

namespace Library\GitHubClient\Client\Objects;

use Library\GitHubClient\Client\Objects\GitHubUser;

class GitHubContributor extends GitHubUser
{

    /*
     * (non-PHPdoc)
     * @see GitHubObject::getAttributes()
     */
    protected function getAttributes()
    {
        return array_merge(parent::getAttributes(), 
                array(
                        'contributions' => 'int'
                ));
    }
    
    /**
     *
     * @var int
     */
    protected $contributions;

    /**
     *
     * @return int
     */
    public function getContributions()
    {
        return $this->contributions;
    }
}

