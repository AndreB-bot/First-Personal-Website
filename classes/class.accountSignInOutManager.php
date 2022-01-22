<?php

include '../scripts/autoloader.php';

use dbQueriesManager;
use userEntity;

/**
 * Provides the functionality of signing in and out the user.
 *
 * @author Andre Bertram.
 */
class accountSignInOutManager {

    private $dbQueriesManager;
    private $signInData;

    public function __construct() {
        $this->dbQueriesManager = new dbQueriesManager();
        $this->connected = $this->dbQueriesManager->isConnected();
    }

    /**
     * 
     * @param type $userInfo
     * @return boolean
     */
    public function verifyUserDetails($userInfo) {
        if ($this->connected) {
            $username = $userInfo['username'];
            $password = sha1($userInfo['password']);

            $userData = $this->dbQueriesManager->getUserData($username);

            if ($userData['username'] === $username && $userData['password'] === $password) {
                $_SESSION['username'] = $username;
                
                return true;
            }
            return false;
        }
    }

    /**
     * 
     * @param type $username
     */
    public function signInUser() {
        // Set the user session id.
        $_SESSION['session_id'] = session_id();
    }

    /**
     * 
     * @param type $username
     * @return type
     */
    public function getUserValidationStatus($username) {
        if ($this->connected) {
            return $this->dbQueriesManager->getUserData($username)['verified'];
        }
    }

    /**
     * 
     */
    public function closeConnection() {
        if ($this->connected) {
            $this->dbQueriesManager->closeConnection();
        }
    }

    /**
     * 
     * @param type $token
     * @return type
     */
    public function verifyUser($token) {
        if ($this->connected) {
            $username = $_SESSION['username'];
            return $this->dbQueriesManager->verifyUser($token, $username);
        }
    }

    /**
     * 
     * @return Boolean
     */
    public function signOutUser() {
        return session_unset();
    }

}
