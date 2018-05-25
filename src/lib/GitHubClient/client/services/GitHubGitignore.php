<?php

namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
use Library\GitHubClient\Client\Objects\GitHubTemplates;
use Library\GitHubClient\Client\Objects\GitHubTemplate;
	

class GitHubGitignore extends GitHubService
{

	/**
	 * Listing available templates
	 * 
	 * @return array<GitHubTemplates>
	 */
	public function listingAvailableTemplates()
	{
		$data = array();
		
		return $this->client->request("/gitignore/templates", 'GET', $data, 200, 'GitHubTemplates', true);
	}
	
	/**
	 * Get a single template
	 * 
	 * @return array<GitHubTemplate>
	 */
	public function getSingleTemplate()
	{
		$data = array();
		
		return $this->client->request("/gitignore/templates/C", 'GET', $data, 200, 'GitHubTemplate', true);
	}
	
}

