<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'includes/vendor/autoload.php';
require_once 'includes/functions.php ';
require_once 'includes/sessions.php ';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

//form handler
if (isset($_POST["submit"])){


   if (empty($_POST['contactUser'])){
       $_SESSION['errorMessage'] = 'Name is required';
   } else {$name = testUserInput($_POST['contactUser']);
       if(!preg_match("/^[A-Za-z\. ]*$/", $name)){
           $_SESSION['errorMessage'] = 'Invalid name';
       }
   }

   if (empty($_POST['contactEmail'])){
       $_SESSION['errorMessage'] = '*Email is required';
   } else {$email = testUserInput($_POST['contactEmail']);
       if(!preg_match("/[a-zA-Z0-9+._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/", $email)){
           $_SESSION['errorMessage'] = 'Invalid email';
       }
   }

   if (empty($_POST["contactMessage"])){
       $_SESSION['errorMessage'] = 'Message is required';
   } else {$msg = $_POST["contactMessage"];
   }

   //test
   if(!empty($_POST['contactUser']) && !empty($_POST['contactEmail'] && !empty($_POST['contactMessage']))) {
       if((preg_match("/^[A-Za-z\. ]*$/", $name)==true)&&(preg_match("/[a-zA-Z0-9+._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/", $email)) == true){

         try {
           //Server settings
           $mail->isSMTP();                                            // Send using SMTP
           $mail->Host       = 'mail.dblinc.net';     // Set the SMTP server to send through
           $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
           $mail->Username   = 'noreply@abornaudit.com';                     // SMTP username
           $mail->Password   = ')isPF{N?Wz.7';                               // SMTP password
           $mail->SMTPSecure = "ssl";         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
           $mail->Port       = 465;                                    // TCP port to connect to

           //Recipients
           $mail->setFrom('noreply@abornaudit.com', 'Mailer');
           $mail->addAddress('support@dblinc.freshdesk.com', 'Aborn Invoice Inquiry');     // Add a recipient
           $mail->addReplyTo($email, $name);
           $mail->addCC('jegan@abornaudit.com');

           // Content
           $mail->isHTML();                                  // Set email format to HTML
           $mail->Subject = 'Carrier Inquiry from '.$name.' ('.$_SESSION['inputScac'].')';
           $mail->Body    =
           $name.' with '.$_SESSION['inquiryScac']. ' says:<br><br>'
           .$_POST['contactMessage'];
           // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

           $mail->send();
            $_SESSION['successMessage'] = 'Inquiry sent!';
            redirect_to('index.php');
         } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
         }


           // $emailTo = 'support@dblinc.freshdesk.com';
           // $subject = $name. ' requests information about '.$inquiryPro.'.';
           // //$sender = $email;
           // $body = $name . ' at '.$email. " says: \n\n" .$msg;
           //
           // if (mail($emailTo, $subject, $body)){
           //     $_SESSION['successMessage'] = 'Mail sent';
           //     redirect_to('inquiry.php');
           // } else {
           //     $_SESSION['errorMessage'] = 'Email failed to send';
           //     redirect_to('inquiry.php');
           // }
       }
   }
}

?>
