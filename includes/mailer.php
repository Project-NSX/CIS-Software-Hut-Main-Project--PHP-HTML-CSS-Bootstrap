<?php
// This file doesn't work when included. The code below must be put into thepage you need to run it on
// I figure this is going to work by putting the send command (at the bottom)
// in the function where visits are made and then put "$Id has sent you a request"
// we'll need to do an SQL query to get the email address of the right person to send the mail to.

// Put at the top of the page
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = 'smtp.hostinger.com';
$mail->SMTPAuth = true;
$mail->Username = 'support@nwsd.online';
$mail->Password = 'twNqxeX4okGE';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('support@nwsd.online');
$mail->Subject = 'New visit request that requires your attention';
$mail->Body = 'A visit request has been made by $_SESSION["id"]. <br/> Please sign into the visiting academic form to respond to this.';

//to get email for hr when college manager makes request
// also used when visit is approved
if ($_SESSION["role"] === "College Manager") {
        $result = "SELECT email FROM user where role = 'Human Resources'";

        $emailList = array();
        while ($row = mysqli_fetch_array($result)) {
                $emailList[] = $row;
            }
        foreach ($emailList as $email) {
                $mail->addAddress("$email");
            }
    }

// to get email for cm when hos makes request
if ($_SESSION["role"] === "Head Of School") {
        $hosid = $_SESSION["college_id"];
        $emailList = "SELECT email FROM user where college_id = '$hosid' AND role = 'College Manager'";
        $mail->addAddress("$result");
    }

// to get email for hos when academic makes request
if ($_SESSION["role"] === "Academic") {
        $aid = $_SESSION["school_id"];
        $emailList = "SELECT email FROM user where school_id = '$aid' AND role = 'Head Of School'";
        $mail->addAddress("$result");
    }

$mail->send();
