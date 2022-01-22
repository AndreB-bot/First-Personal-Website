<?php

session_start();

if ($_SESSION['session_id'] === session_id()) {
    include '../scripts/autoloader.php';
    include '../scripts/nav.php';
    
    $username = $_SESSION['username'];
    $dbQueriesManager = new dbQueriesManager();
    $user_proposal = $dbQueriesManager->getUserSubmission($username);
        
    if ($user_proposal) {
        include '../page/proposal.php';
    } else {
        include '../html/submissions.html';
    }
    
    include '../scripts/footer.php';
    
    $dbQueriesManager->closeConnection();
}
