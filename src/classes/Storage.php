<?php
namespace classes;

use Config\GitConfig;
use SQLite3;

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
    
    /**
     * Get specific or all connection parameters as designated by $id
     * 
     * @param number $id
     * @return array
     */
    public function getConnectionParams($id = 0) {
        $params = [
            'success' => false,
            'error' => '',
            'results' => []
        ];
        $updateTable = false;
        $id = intval($id);
        
        $query = "
            SELECT 
                cons.name, 
                auths.name 
            FROM preferences p
            JOIN connections cons ON cons.id = p.connection_id
            JOIN auth_types auths ON auths.id = p.auth_id
        ";
        
        if ($id === 0) {
            $query .= " ORDER BY last_used DESC";
        } else {
            $query .= " WHERE id = $id";
            $updateTable = true;
        }
        
        try {
            $results = $this->query($query);
            if ($results) {
                $params['success'] = true;
                if ($results->numColumns() > 0) {
                    while(($row = $results->fetchArray(SQLITE3_ASSOC)) !== false) {
                        $params['results'][$row['id']] = [
                            'source_id' => $row['connection_id'],
                            'auth_id' => $row['auth_id']
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            $params['success'] = false;
            $params['error'] = $e->getMessage();
        }
        
        // Update the tables last_used date for this connection source
        if ($updateTable) {
            $now = strftime('%s');
            $query = "
                UPDATE preferences
                SET last_used = $now 
                WHERE id = $id
            ";
            $this->exec($query);
        }
        
        $results = null;
        return $params;
    }
    
    /**
     * @todo Encrypt the database using a key set during first run
     * @param GitConfig $gitConfig
     * @param int $sourceId
     * @param int $authId
     */
    public function saveConnectionParams(GitConfig $gitConfig, $sourceId, $authId) {
        $authFields = serialize($gitConfig->getAuthCredentials());
        $now = strftime('%s');
        $query = "
            INSERT INTO preferences
            VALUES (null, $sourceId, $authId, '$authFields', $now);
        ";
        
        $success = $this->exec($query);
        if (!$success) {
            throw new \Exception('Failed to store source preferences'); 
        }
        return true;
    }
    
    /**
     * Get available connection sources and authentication types
     * 
     * @return array
     */
    public function getConnectionOptions() {
        $results = [];
        $error = true;
        
        // Fech connectable sources
        $result = $this->query("SELECT * FROM connections");
        if ($result && $result->numColumns() > 0) {
            while(($connectionData = $result->fetchArray(SQLITE3_ASSOC)) !== false) {
                $results['connections'][] = $connectionData;
            }
        }
        
        // Fetch connection authentication types
        $result = $this->query("SELECT * FROM auth_types");
        if ($result && $result->numColumns() > 0) {
            while(($connectionData = $result->fetchArray(SQLITE3_ASSOC)) !== false) {
                $results['auth_types'][] = $connectionData;
            }
        }
        
        return $results;
    }
    
    /**
     * Sets up the connection database on first run
     * @uses SQLite3
     * @throws \Exception
     */
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

