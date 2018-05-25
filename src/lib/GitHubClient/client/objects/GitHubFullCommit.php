<?php

namespace Library\GitHubClient\Client\Objects;

use Library\GitHubClient\Client\GitHubObject;
use Library\GitHubClient\Client\Objects\GitHubFullCommitFiles;
use Library\GitHubClient\Client\Objects\GitHubFullCommitStats;


class GitHubFullCommit extends GitHubObject
{
	/* (non-PHPdoc)
	 * @see GitHubObject::getAttributes()
	 */
	protected function getAttributes()
	{
		return array_merge(parent::getAttributes(), array(
			'stats' => 'GitHubFullCommitStats',
			'files' => 'array<GitHubFullCommitFiles>',
		));
	}
	
	/**
	 * @var GitHubFullCommitStats
	 */
	protected $stats;

	/**
	 * @var array<GitHubFullCommitFiles>
	 */
	protected $files;

	/**
	 * @return GitHubFullCommitStats
	 */
	public function getStats()
	{
		return $this->stats;
	}

	/**
	 * @return array<GitHubFullCommitFiles>
	 */
	public function getFiles()
	{
		return $this->files;
	}

}

