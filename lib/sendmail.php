<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
function sendMailEasy($server_setting, $sendToUsername, $sendToFullname, $subject, $body, $option = array())
{
    //Inside function need 'global' for Array or Variable

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = true;
        $mail->do_debug = 0;
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $server_setting['host'];                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $server_setting['username'];                     //SMTP username
        $mail->Password   = $server_setting['password'];                              //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = $server_setting['port'];                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->CharSet    = $server_setting['charset'];
        //Recipients
        $mail->setFrom($server_setting['username'], $server_setting['fullname']);
        $mail->addAddress($sendToUsername, $sendToFullname);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo($server_setting['username'], $server_setting['fullname']);
        if (!empty($option['addCC'])) {
            $mail->addCC('cc@example.com');
        }
        if (!empty($option['addBCC'])) {
            $mail->addBCC('bcc@example.com');
        }


        //Attachments
        if (!empty($option['attachment'])) {
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $mail->addAttachment($option['attachment']);            //Add attachments
        }
        if (!empty($option['attachment_S']['path']) and !empty($option['attachment_S']['new_name'])) {
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            $mail->addAttachment($option['attachment_S']['path'], $option['attachment_S']['new_name']);
        }

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        // echo '---------- Message has been successed ----------';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
