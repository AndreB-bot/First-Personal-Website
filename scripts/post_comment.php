<?php
session_id();
include '../scripts/autoloader.php';

$userComment = filter_input_array(INPUT_POST);

if($userComment['comment']) {
    
    $userContentManager = new userContentManager($_SESSION['username']);
    
    if($userContentManager->addPost($userComment['comment'])) {
      echo json_encode($userContentManager->getUserMostCurrentComments());    
    }
    
    $userContentManager->closeConnection();
    exit();
}
