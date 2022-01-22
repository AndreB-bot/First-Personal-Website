<?php
include '../scripts/autoloader.php';
use dbQueriesManager;

/**
 * Performs the required user table queries and updates.
 *
 * @author cs213
 */
class userStorageManager {
    private $dbQueriesManager;
    private $isConnected;

    
    public function __construct() {
        $this->dbQueriesManager = new dbQueriesManager();
        $this->isConnected = $this->dbQueriesManager->isConnected();
    }
    
    public function getUser($username) {
        if($this->isConnected) {
        $userData = $this->getUserData($username);
        return new userEntity($userData);  
        }
    }
    
    public function getUserData($username) {
        if($this->isConnected) {
        return $this->dbQueriesManager->getUserData($username);
        }
    }
    
    public function addNewUser($userInfo) {
        if($this->isConnected) {
        return $this->dbQueriesManager->insertUserEntry($userInfo);
        }
    }
    
    public function closeConnection() {
        $this->dbQueriesManager->closeConnection();
    }
}


?>