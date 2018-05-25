<?php

namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
	

class GitHubActivityStarring extends GitHubService
{

	/**
	 * List Stargazers
	 * 
	 */
	public function listStargazers($owner, $repo)
	{
		$data = array();
		
		return $this->client->request("/user/starred/$owner/$repo", 'PUT', $data, 204, '');
	}
	
}

