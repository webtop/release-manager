<?php

namespace Classes;

class Common {
    const MODE_DEVELOPMENT = 'development';
    
    public static function debug($what, $exit = false) {
        $output = print_r($what, true);
        print "<pre>$output</pre>";
        
        if ($exit) {
            exit;
        }
    }
}