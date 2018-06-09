<?php

namespace Library\GitHubClient\Client\Objects;

use Library\GitHubClient\Client\Objects\GitHubRepo;

class GitHubFullRepo extends GitHubRepo
{

    /*
     * (non-PHPdoc)
     * @see GitHubObject::getAttributes()
     */
    protected function getAttributes()
    {
        return array_merge(parent::getAttributes(), array());
    }
}

