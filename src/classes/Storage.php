<?php
namespace classes;

use SQLite3;
use Config\GitConfig;

/**
 * Lightweight data storage class
 * @author Paul Allsopp <paul.allsopp@digital-pig.com>
 * @see \Singleton
 * @todo UNFINISHED
 */
class Storage extends \SQLite3 {
    private static $instance = null;
    private static $instanceError = '';
    
    public function __construct() {
        $this->open(BASE_PATH . '/../release_manager.db');
        $this->setup();
    }
    
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Storage();
        }
        return self::$instance;
    }
    
    public function getConnectionParameters() {
        
    }
    
    public function saveConnectionParams(GitConfig $gitConfig) {
        
    }
    
    public function getConnectionOptions() {
        $results = [];
        $error = true;
        
        // Fech connectable sources
        $result = $this->query("SELECT * FROM connections");
        if ($result && $result->numColumns() > 0) {
            while(($connectionData = $result->fetchArray()) !== false) {
                $results['connections'][] = $connectionData;
            }
        }
        
        // Fetch connection authentication types
        $result = $this->query("SELECT * FROM auth_types");
        if ($result && $result->numColumns() > 0) {
            while(($connectionData = $result->fetchArray()) !== false) {
                $results['auth_types'][] = $connectionData;
            }
        }
        
        return $results;
    }
    
    private function getConnectionProfileId($profile) {
        
    }
    
    private function setup() {
        if (!file_exists(BASE_PATH . '/../release_manager.db')) {
            $query = <<<SQL
                CREATE TABLE IF NOT EXISTS connections (
                    id INTEGER PRIMARY KEY NOT NULL,
                    name TEXT NOY NULL,
                    api_url TEXT NOT NULL,
                    files_url TEXT
                );
                
                CREATE TABLE IF NOT EXISTS auth_types (
                    id INTEGER PRIMARY KEY NOT NULL,
                    name TEXT NOT NULL,
                    auth_name TEXT NOT NULL,
                    auth_field_1 TEXT,
                    auth_field_2 TEXT
                );
                
                CREATE TABLE IF NOT EXISTS preferences (
                	id INTEGER PRIMARY KEY NOT NULL,
                	connection_id INTEGER NOT NULL,
                	auth_id INTEGER NOT NULL,
                	auth_fields TEXT NOT NULL
                );
                
                CREATE UNIQUE INDEX uidx_api ON connections(api_url); 
                
                INSERT INTO connections VALUES (1, "GitHub", "https://api.github.com", "");
                
                INSERT INTO auth_types VALUES (1, "None (Public repos only)", "auth_none", null, null);
                INSERT INTO auth_types VALUES (2, "Basic (Username/Password)", "auth_basic", "username", "password");
                INSERT INTO auth_types VALUES (3, "Personal Access Token", "auth_token", "token", null);
                INSERT INTO auth_types VALUES (4, "OAuth App", "auth_oauth", "app_id", "app_secret");
SQL;
            if (!$this->exec($query)) {
                throw new \Exception("Failed to setup local DB. Please check folder permissions of /private folder [set to 755]");
                exit(1);
            }
        }
    }
}

