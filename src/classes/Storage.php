<?php
namespace classes;

use SQLite3;
use Config\GitConfig;

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
                self::$instance->setup();
            } catch (\Exception $e) {
                self::$instance = self;
                self::$instanceError = $e->getMessage();
            }
        }
        return self::$instance;
    }
    
    public function saveConnectionParams(GitConfig $gitConfig) {
        
    }
    
    private function setup() {
        $query = <<<SQL
            CREATE TABLE IF NOT EXISTS connections (
                id INT PRIMARY KEY NOT NULL,
                api_url TEXT NOT NULL,
                files_url TEXT,
                auth_type INT NOT NULL
            );

            CREATE TABLE IF NOT EXISTS auth_types (
                id INT PRIMARY KEY NOT NULL,
                auth_name TEXT NOT NULL,
                auth_field_1 TEXT NOT NULL,
                auth_field_2 TEXT NOT NULL
            );

            CREATE UNIQUE INDEX uidx_api
            ON connections(api_url); 
    }
}

