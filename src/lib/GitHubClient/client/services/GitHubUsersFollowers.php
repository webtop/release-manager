<?php

namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;

	

class GitHubUsersFollowers extends GitHubService
{

	/**
	 * List followers of a user
	 * 
	 */
	public function listFollowersOfUser($user)
	{
		$data = array();
		
		return $this->client->request("/user/following/$user", 'PUT', $data, 204, '');
	}
	
}

