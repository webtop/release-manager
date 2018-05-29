<?php

namespace Library\GitHubClient\Client\Objects;

use Library\GitHubClient\Client\GitHubObject;

class GitHubTemplate extends GitHubObject
{

    /*
     * (non-PHPdoc)
     * @see GitHubObject::getAttributes()
     */
    protected function getAttributes()
    {
        return array_merge(parent::getAttributes(), 
                array(
                        'name' => 'string',
                        'source' => 'string'
                ));
    }
    
    /**
     *
     * @var string
     */
    protected $name;
    
    /**
     *
     * @var string
     */
    protected $source;

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }
}

