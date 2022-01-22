<?php

session_start();
include '../scripts/autoloader.php';

/**
 * Manages user content.
 *
 * @author Andre Bertram
 */
class userContentManager {

    private $dbManager;
    private $user;
    private $isConnected;

    public function __construct($username) {
        $this->dbManager = new dbQueriesManager();
        $this->isConnected = $this->dbManager->isConnected();
        $this->user = $this->getUserEntity($username);
    }

    /**
     * 
     * @param type $username
     * @return \userEntity
     */
    public function getUserEntity($username) {
        if ($this->isConnected) {
            $userData = $this->dbManager->getUserData($username);
            return new userEntity($userData);
        }
    }

    /**
     * 
     * @param type $userInput
     * @return type
     */
    public function submitSubmission($userInput) {
        if ($this->isConnected) {
            // If user already has a submission, return.
            if ($this->dbManager->getUserSubmission($this->user->getUsername())) {
                return false;
            }
            $username = $_SESSION['username'];
            return $this->dbManager->insertSubmissionEntry($userInput, $username);
        }
    }

    /**
     * 
     * @param type $files
     * @param type $username
     * @return boolean
     */
    public function uploadFiles($files) {
        $folder = $this->user->getAssignedFolder();

        $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);

        $target_path = "$rootDir/cdn/$folder/";
        $success = [];

        foreach ($files as $file) {
            $path = $target_path . basename($file['name']);

            if (move_uploaded_file($file['tmp_name'], $path)) {
                $success[] = true;
            }
        }

        if (count($success) >= 1) {
            return true;
        }
    }

    public function closeConnection() {
        $this->dbManager->closeConnection();
    }

    public function addPost($comment) {
        if ($this->isConnected) {
            return $this->dbManager->addCommentsEntry(
                            $this->user->getUsername(), $comment
            );
        }
    }

    public function getUserComments() {
        if ($this->isConnected) {
            return $this->dbManager->getUserComments($this->user->getUsername());
        }
    }

    public function getUserMostCurrentComments() {
        if ($this->isConnected) {
            return $this->dbManager->getMostRecentUserComment(
                            $this->user->getUsername()
            );
        }
    }

}

?>