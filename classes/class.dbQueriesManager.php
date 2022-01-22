<?php

include '../scripts/autoloader.php';

/**
 * Handles all database queries. 
 *
 * @author Andre Bertram.
 */
class dbQueriesManager {

    private $password;
    private $user;
    private $connected;
    private $host;
    private $dbName;
    private $db;

    public function __construct() {
        $this->user = "cs213user";
        $this->password = "letmein";
        $this->host = "localhost";
        $this->dbName = "mainDB";

        $this->connected = $this->openDBConnection();
    }

    private function openDBConnection() {
        try {
            // Connect to server and select database
            $this->db = new mysqli($this->host, $this->user, $this->password, $this->dbName);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
        return $this->db ? true : false;
    }

    /**
     * Adds a new user entry to the user table.
     * 
     * @param array $userInfo
     */
    public function insertUserEntry($userInfo) {
        $fName = ucfirst($userInfo['fName']);
        $lName = ucfirst($userInfo['lName']);
        $username = $userInfo['username'];
        $password = $userInfo['password'];
        $email = $userInfo['email'];
        $address = [
            'street_address' => $userInfo['street_address'],
            'city' => $userInfo['city'],
            'province' => $userInfo['province'],
            'postal_code' => $userInfo['postal_code']
        ];
        $address = json_encode($address);
        $intro = $userInfo['intro'];
        $company_name = ucfirst($userInfo['company_name']);
        $folder = 'folder_' . $userInfo['username'];

        $sql_query = 'INSERT INTO users VALUES (?,?,?,SHA1(?),?,?,CURDATE(),?,?,?,0,0)';
        $stmt = $this->db->prepare($sql_query);

        $types = str_repeat('s', count($userInfo) - 2);
        $stmt->bind_param(
                $types,
                $fName,
                $lName,
                $username,
                $password,
                $email,
                $address,
                $intro,
                $company_name,
                $folder
        );

        if ($stmt->execute()) {
            $this->createUserFolder($folder);
            //$this->deleteAllUsers();
            //return true; 
            return $this->setUserAuthToken($username);
        }
    }

    /**
     * Retrieves user data from the database.
     * 
     * @param array $username
     *   The user to be queried.
     * 
     * @return array
     *   Query results.
     */
    public function getUserData($username) {
        $sql_query = 'SELECT * FROM users WHERE username = ?';

        $stmt = $this->db->prepare($sql_query);
        $stmt->bind_param("s", $username);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Returns true or false if database connection was established. 
     * 
     * @return Boolean
     *   The connection status of the database.
     */
    public function isConnected() {
        return $this->connected;
    }

    /**
     * 
     * @param type $folder_name
     */
    private function createUserFolder($folderName) {
        $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
        $path = "$rootDir/cdn/$folderName";
        mkdir($path, 0733);
    }

    /**
     * 
     * @param type $username
     * @return type
     */
    private function setUserAuthToken($username) {
        $token = sha1(rand());

        $sql_query = 'INSERT INTO user_token VALUES (?,SHA1(?))';

        $stmt = $this->db->prepare($sql_query);
        $stmt->bind_param("ss", $username, $token);

        return $stmt->execute() ? $token : false;
    }

    /**
     * Close database connection.
     */
    public function closeConnection() {
        $this->db->close();
    }

    /**
     * Delete all users.
     */
    private function deleteAllUsers() {
        $sql_query = 'DELETE FROM users';

        $stmt = $this->db->prepare($sql_query);
        $stmt->execute();
    }

    /**
     * Gets a single column values or all.
     * 
     * @param type $tableName
     * @return type
     */
    public function getUserColumnValues($columnName, $value = NULL) {
        $sql_query = "SELECT $columnName FROM users where $columnName = ?";

        $stmt = $this->db->prepare($sql_query);

        $value ? $stmt->bind_param("s", $value) : $stmt->bind_param("s", $columnName);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Updates the user verified value with a INNER JOIN on user_token.
     * 
     * @param type $token
     * @return type
     */
    public function verifyUser($token, $username) {

        $sql_query = "SELECT username, token FROM user_token "
                . "WHERE username = ? AND token = SHA1(?)";

        $stmt = $this->db->prepare($sql_query);
        $stmt->bind_param("ss", $username, $token);
        $stmt->execute();

        $results = $stmt->get_result()->num_rows;
        $stmt->close();

        // If the token does exists, then update the verified value for the user.
        if ($results) {
            $sql_query = "UPDATE users INNER JOIN user_token AS ut ON users.username = ut.username "
                    . "SET verified = 1 WHERE users.username = ? AND ut.token = SHA1(?)";

            $stmt = $this->db->prepare($sql_query);
            $stmt->bind_param("ss", $username, $token);
            $results = $stmt->execute();
            $stmt->close();
        }

        return $results;
    }

    /**
     * 
     * @param type $userInput
     * @return boolean
     */
    public function insertSubmissionEntry($userInput, $username) {
        $members = $this->prepareMembers($userInput);

        $project_details = [
            'title' => $userInput['title'],
            'description' => $userInput['description'],
            'chosen_dev_work' => $userInput['chosen-dev-work'],
            'budget' => $userInput['budget'],
            'members' => $members,
        ];

        foreach ($project_details as $details => $value) {
            if (is_null($value)) {
                $project_details = false;
                break;
            }
        }

        $project_details ? $project_details = json_encode($project_details) : null;

        $filenames = json_encode($userInput['fileNames']);

        $sql_query = 'INSERT INTO users_submissions VALUES (?,?,CURDATE(),?,0)';
        $stmt = $this->db->prepare($sql_query);
        $stmt->bind_param("sss", $username, $project_details, $filenames);

        if ($stmt->execute()) {
            return true;
        }
    }

    /**
     * 
     * @param type $userInput
     * @return type
     */
    private function prepareMembers($userInput) {
        $members = [];

        foreach ($userInput as $member => $name) {
            if (stristr($member, "member")) {
                foreach ($userInput as $position => $value) {
                    if (stristr($position, "position") &&
                            stristr($position, substr($member, -1))
                    ) {
                        $members[$name] = $value;
                    }
                }
            }
        }

        return $members;
    }

    public function getUserSubmission($username) {
        $sql_query = 'SELECT * FROM users_submissions WHERE username = ?';

        $stmt = $this->db->prepare($sql_query);
        $stmt->bind_param("s", $username);
        $stmt->execute();

        return $stmt->get_result()->fetch_object();
    }

    /**
     * 
     * @param type $username
     * @param type $comment
     * @return type
     */
    public function addCommentsEntry($username, $comment) {
        $sql_query = 'INSERT INTO comments (username,comment) VALUES (?,?)';

        $stmt = $this->db->prepare($sql_query);
        $stmt->bind_param("ss", $username, $comment);

        return $stmt->execute();
    }

    /**
     * 
     * @param type $username
     */
    public function getUserComments($username) {
        $sql_query = 'SELECT * FROM comments WHERE username = ?';

        $stmt = $this->db->prepare($sql_query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $results = [];

        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }

        return $results;
    }

    public function getMostRecentUserComment($username) {
        $sql_query = 'SELECT * FROM comments'
                . ' WHERE username = ?'
                . ' ORDER BY date DESC';

        $stmt = $this->db->prepare($sql_query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

}

?>