<?php

namespace Classes;

use Slim;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class Common 
{
    const MODE_DEVELOPMENT = 'development';
    
    public function updateSettings() {
        
    }
    
    public static function debug($what, $exit = false) 
    {
        $output = print_r($what, true);
        print "<pre>$output</pre>";
        
        if ($exit) {
            exit;
        }
    }
    
    public static function cache($path) 
    {
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
     * @param unknown $template
     * @param unknown $viewArgs
     * @return \Slim\Http\Response
     */
    public static function buildView(Response $response, PhpRenderer $viewRenderer, $template, $viewArgs)
    {
        // Render the view
        $body = $viewRenderer->fetch($template, $viewArgs);
        
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
}