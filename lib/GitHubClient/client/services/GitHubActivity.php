<?php
namespace Library\GitHubClient\Client\Services;

use Library\GitHubClient\Client\GitHubClient;
use Library\GitHubClient\Client\GitHubService;
use Library\GitHubClient\Client\Services\GitHubActivityEvents;
use Library\GitHubClient\Client\Services\GitHubActivityFeeds;
use Library\GitHubClient\Client\Services\GitHubActivityNotifications;
use Library\GitHubClient\Client\Services\GitHubActivitySettings;
use Library\GitHubClient\Client\Services\GitHubActivityStarring;
use Library\GitHubClient\Client\Services\GitHubActivityWatching;

class GitHubActivity extends GitHubService {

    /**
     *
     * @var GitHubActivityEvents
     */
    public $events;

    /**
     *
     * @var GitHubActivityFeeds
     */
    public $feeds;

    /**
     *
     * @var GitHubActivityNotifications
     */
    public $notifications;

    /**
     *
     * @var GitHubActivitySettings
     */
    public $settings;

    /**
     *
     * @var GitHubActivityStarring
     */
    public $starring;

    /**
     *
     * @var GitHubActivityWatching
     */
    public $watching;

    /**
     * Initialize sub services
     */
    public function __construct(GitHubClient $client) {
        parent::__construct($client);
        
        $this->events = new GitHubActivityEvents($client);
        $this->feeds = new GitHubActivityFeeds($client);
        $this->notifications = new GitHubActivityNotifications($client);
        $this->settings = new GitHubActivitySettings($client);
        $this->starring = new GitHubActivityStarring($client);
        $this->watching = new GitHubActivityWatching($client);
    }
}

