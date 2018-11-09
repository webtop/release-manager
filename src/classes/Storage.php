<?php
namespace classes;

use SQLite3;

class Storage {
    private static $instance = null;
    private static $instanceError = '';
    
    private $db = null;
    
    private function __construct($db) {
        $this->db = $db;
    }
    
    public static function getInstance() {
        if (is_null(self::$instance)) {
            try {
                $db = new \SQLite3('release_manager.db');
                self::$instance = new Storage($db);
            } catch (\Exception $e) {
                self::$instance = self;
                self::$instanceError = $e->getMessage();
            }
        }
        return self::$instance;
    }
    
    public function query($sql, $params = []) {
        
    }
}

