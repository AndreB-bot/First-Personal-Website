<?php

session_start();
include '../scripts/autoloader.php';

$userInput = filter_input_array(INPUT_POST);

if (isset($userInput['title'])) {

    // Let's get rid of empty values in the userInput.
    foreach ($userInput as $input => $value) {
        if (!$value) {
            unset($userInput[$input]);
        }
    }

    $file_names = [];
    $files = [];

    foreach ($_FILES as $file) {
        if ($file['name']) {
            $files[] = $file;
            $file_names[] = $file['name'];
        }
    }

    $username = $_SESSION['username'];
    $userInput['fileNames'] = $file_names;

    $contentManager = new userContentManager($username);

    $status = 'FAILED';

    if ($contentManager->submitSubmission($userInput)) {
        $status = 'SUBMITTED';
        if (!empty($files) && $contentManager->uploadFiles($files)) {
            $contentManager->closeConnection();

            echo json_encode(['status' => 'SUCCESS']);
            exit();
        }
    }

    echo json_encode(['status' => $status]);
    exit();
}