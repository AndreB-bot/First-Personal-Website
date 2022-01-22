<?php
session_start();
include '../scripts/autoloader.php';

if(filter_input(INPUT_POST, 'sign_out')) {
    $accountSignOutManager = new accountSignInOutManager();
        
    if($accountSignOutManager->signOutUser()) {
        echo 'success';
    }
    else {
        echo 'failure';
    }
}
