<?php

namespace Classes;

use Slim;

class Common 
{
    const MODE_DEVELOPMENT = 'development';
    
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
    
    public static function buildView($content)
    {
        $app = new Slim\App();
        $container = $app->getContainer();
        $view = $container['view'];
        
        
    }
}