<?php
include '../scripts/autoloader.php';

use PHPMailer;
use userStorage;

/**
 * Provides the functionality of signing up the user.
 *
 * @author Andre Bertram
 */
class accountSignUpManager {
    private $phpMailer;
    private $userStorage;

    public function __construct() {
        $this->phpMailer = new PHPMailer();
        $this->userStorage = new userStorageManager();
    }

    public function addNewUser($userInfo, $gmail = false) {
        $existing_user = $this->userStorage
                ->getUserData($userInfo);

        if (empty($existing_user)) {
            $token = $this->userStorage->addNewUser($userInfo);
            
            
            // Experincing issues on my machine with sending email. So this is
            // bypass.
            if($gmail && $token) {
                $user = $this->getUser($userInfo['username']);
                $fName = $user->getFirstName();
                
                $message = "<div style=\"text-align: center;\">"
                        ."<p>"
                        . "<img src=\"https://www.pseforspeed.com/wp-content/uploads/2018/08/welcome.png.png\" "
                        . "alt=\"welcome image\" width=\"500\" height=\"100\">"
                        . "</p>"
                        . "<p><strong>Welcome to AÉB Software Consultancy, $fName!</strong></p>"
                        . "<p>Here's your verification code:</p>"
                        . "<strong>$token</strong>"
                        . "</div>";

                $subject = 'Welcome to AÉB Software Consultancy';
                
                $this->userStorage->closeConnection();
                return $this->sendEmail($user->getEmail(), $subject, $message);
            }
            
            return $token;
        }
    }

    private function getUser($username) {
        return $this->userStorage->getUser($username);
    }
    
    private function sendEmail($to, $subject, $message) {
        // optional, gets called from within class.phpmailer.php if not already loaded
        include("class.smtp.php");

        $mail = $this->phpMailer;
        $mail->CharSet = "UTF-8";
        // telling the class to use SMTP
        $mail->IsSMTP();
        // enables SMTP debug information (for testing)
        // 1 = errors and messages
        // 2 = messages only
        $mail->SMTPDebug = 0;
        // enable SMTP authentication
        $mail->SMTPAuth = true;
        // sets the prefix to the servier
        $mail->SMTPSecure = "tls";
        // sets GMAIL as the SMTP server
        $mail->Host = "smtp.gmail.com";
        // set the SMTP port for the GMAIL server
        $mail->Port = 587;

        // GMAIL username
        $mail->Username = "test@gmail.com";
        // GMAIL password
        $mail->Password = "test";
        //Set reply-to email this is your own email, not the gmail account 
        //used for sending emails
        $mail->SetFrom('test@yopmail.com');
        $mail->FromName = "A.Bertram";
        // Mail Subject
        $mail->Subject = $subject;

        //Main message
        $mail->MsgHTML($message);

        //Your email, here you will receive the messages from this form. 
        //This must be different from the one you use to send emails, 
        //so we will just pass email from functions arguments
        $mail->AddAddress($to, "");
        if (!$mail->Send()) {
            //couldn't send
            return false;
        } else {
            //successfully sent
            return true;
        }
    }

}

?>