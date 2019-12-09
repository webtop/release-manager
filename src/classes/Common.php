<?php

namespace Classes;

use Slim;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

/**
 * Common class for global/static utility functiuons
 * @author Paul Allsopp <paul.allsopp@digital-pig.com>
 *
 */
class Common {
    
    const MODE_DEVELOPMENT = 'development';
    
    const GITHUB_CONFIG = 1;
    const GITLAB_CONFIG = 2;
    
    const GIT_AUTH_NONE = 1;
    const GIT_AUTH_BASIC = 2;
    const GIT_AUTH_TOKEN = 3;
    const GIT_AUTH_OAUTH = 4;
    
    /**
     * @stub Update current settings
     */
    public function updateSettings() {}
    
    /**
     * Print any type of object
     * 
     * @param any $what
     * @param bool $exit
     */
    public static function debug($what, $exit = false) {
        $output = print_r($what, true);
        print "<pre>$output</pre>";
        
        if ($exit) {
            exit;
        }
    }
    
    /**
     * Determine existence of cache and return it if unchanged
     * 
     * @param string $path
     * @return string
     */
    public static function cache($path) {
        $filePath = BASE_PATH . $path;
        if (file_exists($filePath)) {
            $cacheHash = md5(filemtime($filePath));
            $path .= '?cache=' . $cacheHash;
        }
        
        return $path;
    }
    
    /**
     * Generate a response output wrapped in a layout
     * 
     * @param Response $response
     * @param PhpRenderer $viewRenderer
     * @param string $template
     * @param mixed $viewArgs
     * @return \Slim\Http\Response
     */
    public static function buildView(Response $response, PhpRenderer $viewRenderer, $template, $viewArgs = []) {
        // Render the view
        $body = $viewRenderer->fetch($template . '.phtml', $viewArgs);
        
        // Render the layout
        $header = $viewRenderer->fetch('layout/header.phtml', $viewArgs);
        $content = $viewRenderer->fetch('layout/content.phtml', ['content' => $body]);
        $footer = $viewRenderer->fetch('layout/footer.phtml', $viewArgs);
        
        // Combine layout and view
        $output = $header . $content . $footer;
        
        // Write and return the response
        $response->getBody()->write($output);
        return $response;
    }
    
    /**
     * Fetch a partial template, useful for table rows etc
     * 
     * @param PhpRenderer $viewRenderer
     * @param string $template
     * @param array $viewArgs
     * @return mixed
     */
    public static function getPartialView(PhpRenderer $viewRenderer, $template, $viewArgs = []) {
        $partial = $viewRenderer->fetch('partials/' . $template . '.phtml', $viewArgs);
        return $partial;
    }
    
    /**
     * Convert a field name to user-interface text
     * 
     * Ex. 'first_name' or 'first-name' becomes 'First Name'
     * @param string $value
     * @return string
     */
    public static function fieldToUserText($value) {
        return ucwords(str_replace(['_', '-'], ' ', $value));
    }
}