<?php
// This file doesn't work when included. The code below must be put into thepage you need to run it on
// I figure this is going to work by putting the send command (at the bottom)
// in the function where visits are made and then put "$Id has sent you a request"
// we'll need to do an SQL query to get the email address of the right person to send the mail to.

// Put at the top of the page
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/PHPMailer/src/Exception.php';
require '../vendor/PHPMailer/src/PHPMailer.php';
require '../vendor/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

$mail ->isSMTP();
$mail ->Host ='smtp.hostinger.com';
$mail ->SMTPAuth = true;
$mail ->Username = 'support@nwsd.online';
$mail ->Password ='twNqxeX4okGE';
$mail ->SMTPSecure = 'tls';
$mail ->Port = 587;


$mail ->setFrom('support@nwsd.online');
$mail ->addAddress('spectre-nsx@outlook.com');
$mail ->Subject = 'Stuff';
$mail ->Body = 'This is a test';

// Put in the function to send the mail

 $mail ->send();
?>