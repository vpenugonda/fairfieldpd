<?php
require "config.php";
$qqq = mysqli_query($link,"SELECT * FROM `tbl_users` WHERE `role`='admin'");
$hh = mysqli_fetch_assoc($qqq);
if (!empty($_POST)) {
    $name = (!empty($_POST['name'])) ? filter_input(INPUT_POST, 'name') : "";
    //$address = (!empty($_POST['address'])) ? filter_input(INPUT_POST, 'address') : "";
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone');
    $message = filter_input(INPUT_POST, 'message');
    $html = "<div style='width:50%;margin:0 auto;border:solid 2px #000;padding:20px;overflow:hidden;font-family:Arial;font-size:13px'><p><b>Name of The User</b> : " . getStr($name) . "</p>";
    $html .= "<p><b>Email</b> : " . $email . "</p>";
    $html .= "<p><b>Phone No</b> : " . $phone . "</p>";
    $html .= "<p><b>Message</b> :" . $message . "</p></div>";
}


//echo $name,$email,$phone,$message;
require 'mailer/class.phpmailer.php';
$mail = new PHPMailer;
$mail->From = $email;
$mail->FromName = $name;
//$mail->addAddress($hh['email'], 'Worldoutreachinternational');     // Add a recipient
$mail->addAddress("khajamohiddin.476@gmail.com", 'Worldoutreachinternational');     // Add a recipient
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Contact from Worldoutreachinternational';
$mail->Body = $html;
// Always set content-type when sending HTML email
//$headers = "MIME-Version: 1.0" . "\r\n";
//$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

//$mail = mail("$hh['email']","Contact from Worldoutreachinternational",$html,$headers);
if (!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo '<b>Mail has been sent Successfully!</b>';
}