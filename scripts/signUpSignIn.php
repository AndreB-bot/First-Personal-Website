<?php

session_start();
include '../scripts/autoloader.php';

$userInfo = filter_input_array(INPUT_POST);

// If the user is signing up. Do this.
if (count($userInfo) > 2) {
    $accountSignUpManager = new accountSignUpManager();

    // @todo Set 2nd param to true once email issue is resolved.
    $token = $accountSignUpManager->addNewUser($userInfo);

    if ($token) {
        $name = ucfirst($userInfo['fName']);
        $message = "Here's your verification code: $token";

        if (is_bool($token)) {
            $message = "Please check your email for a verification code.";
        }

        echo json_encode(['message' => $message]);
    }

    exit();
}

// Verifies if the values entered for email, company name and username 
// alsredy exists in database.
if (isset($userInfo['id'])) {
    $table_name = $userInfo['id'];

    if ($table_name == "email" ||
            $table_name == "company_name" ||
            $table_name == "username"
    ) {
        $value = $userInfo['value'];
        $dbQueriesManager = new dbQueriesManager();

        if ($dbQueriesManager->isConnected()) {
            $result = $dbQueriesManager->getUserColumnValues($table_name, $value);
        }

        if ($result) {
            echo "true";
        } else {
            echo "false";
        }

        $dbQueriesManager->closeConnection();
    }

    exit();
}

// Attempts to sign in the user if they are already verified.
if (isset($userInfo['username'])) {

    $accountSignInManager = new accountSignInOutManager();
    $isVerified = $accountSignInManager->verifyUserDetails($userInfo);

    if ($isVerified) {
        $username = $_SESSION['username'];
        $isValidated = $accountSignInManager->getUserValidationStatus(
                $username
        );

        if (!$isValidated) {
            echo json_encode(['notValidated' => 'true']);
        } else {
            $accountSignInManager->signInUser($username);
            echo json_encode(['validated' => 'true']);
        }
    } else {
        echo json_encode(['hasErrors' => 'true']);
    }

    $accountSignInManager->closeConnection();
    exit();
}

// Verifies the user and signs them in.
if (isset($userInfo['verification-code'])) {

    $token = $userInfo['verification-code'];
    $accountSignInManager = new accountSignInOutManager();

    $isNowVerified = $accountSignInManager->verifyUser($token);

    if ($isNowVerified) {
        $accountSignInManager->signInUser();

        echo "true";
    } else {
        echo "false";
    }

    $accountSignInManager->closeConnection();
    exit();
}