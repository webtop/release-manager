<?php

namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;

use Library\GitHubClient\Client\Objects\GitHubFeeds;
	

class GitHubActivityFeeds extends GitHubService
{

	/**
	 * List Feeds
	 * 
	 * @return GitHubFeeds
	 */
	public function listFeeds()
	{
		$data = array();
		
		return $this->client->request("/feeds", 'GET', $data, 200, 'GitHubFeeds');
	}
	
}

