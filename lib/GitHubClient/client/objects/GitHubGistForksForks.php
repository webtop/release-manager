<?php

namespace Library\GitHubClient\Client\Objects;

use Library\GitHubClient\Client\GitHubObject;

class GitHubGistForksForks extends GitHubObject
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

