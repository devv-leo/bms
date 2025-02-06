<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';
function email_send($address,$header,$msg)
{
           $mail = new PHPMailer(true);
           $mail->IsSMTP();
           $mail->Mailer = "smtp";
           $mail->Host = "smtp.gmail.com";
           $mail->Port = 587;
           $mail->SMTPSecure = "tls";
           $mail->SMTPAuth = true;
           $mail->Username = "lekan.code@gmail.com";// enter your gmail account 
           $mail->Password = "hwmtgjrljztzeclv"; //enter your email password
           $mail->AddAddress($address);
           $mail->SetFrom("lekan.code@gmail.com", "Sky Bank Limited");
           $mail->Subject  = $header;
           $mail->Body     = $msg;
           if(!$mail->Send()) {
           echo 'Message was not sent.';
           echo 'Mailer error: ' . $mail->ErrorInfo;
           } else {
           echo 'Message has been sent.';
           }
 }
?>

