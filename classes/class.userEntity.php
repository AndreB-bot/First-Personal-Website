<?php

include '../scripts/autoloader.php';

use userStorage;

/**
 * Creates user objects.
 *
 * @author Andre Bertram
 */
class userEntity {

    private $fName;
    private $lName;
    private $address;
    private $companyName;
    private $assignedFolder;
    private $intro;
    private $email;
    private $username;

    public function __construct(
            $userData
    ) {
        if ($userData) {
            $this->address = $userData['address'];
            $this->companyName = $userData['company_name'];
            $this->intro = $userData['intro'];
            $this->email = $userData['email'];
            $this->username = $userData['username'];
            $this->assignedFolder = $userData['assigned_folder'];
            $this->fName = $userData['fName'];
            $this->lName = $userData['lName'];
        }
    }

    public function getUsername() {
        return $this->username;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getIntro() {
        return $this->intro;
    }

    public function getCompanyName() {
        return $this->companyName;
    }

    public function getAssignedFolder() {
        return $this->assignedFolder;
    }

    public function getFullName() {
        return $this->fName . ' ' . $this->lName;
    }

    public function getFirstName() {
        return $this->fName;
    }

    public function getLastName() {
        return $this->lName;
    }

}

?>