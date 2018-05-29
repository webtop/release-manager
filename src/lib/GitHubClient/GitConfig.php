<?php
namespace Library\GitHubClient;

/**
 * Interface to ensure Git sources are adhered to
 *
 * @author Paul Allsopp <paul.allsopp@digital-pig.com>
 */
interface GitConfig
{

    /**
     * Get the URL for the Git API
     * 
     * @return string
     */
    public function getApiUrl (): string;

    /**
     * Get the URL for the Git content
     * 
     * @return string
     */
    public function getFilesUrl (): string;

    /**
     * Get the Git source owner(vendor)
     * 
     * @return string
     */
    public function getOwner (): string;

    /**
     * Get the personal access token for the Git soure
     * 
     * @return string
     */
    public function getAccessToken (): string;
}
