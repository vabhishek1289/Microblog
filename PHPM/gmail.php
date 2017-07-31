<?php
date_default_timezone_set('Etc/UTC');
require '/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = "";
$mail->Password = "";
$mail->setFrom('vashishthaaditya20@gmail.com', 'First Last');
$mail->addReplyTo('replyto@example.com', 'First Last');
$mail->addAddress('adityakamal@outlook.com', 'John Doe');
$mail->Subject = 'Welcome to Bug';
$html_data = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>PHPMailer Test</title>
</head>
<body>
<div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
  <div align="left">
    <a href="https://github.com/PHPMailer/PHPMailer/"><img src="/buglogo.jpg" height="50" width="100" alt="PHPMailer rocks"></a>
  </div>
  <h1>Welcome User,</h1>
  <p>Click the link below to verify your account</p>
</div>
</body>
</html>';
$mail->msgHTML($html_data, dirname(__FILE__));
$mail->AltBody = 'Verify your email account.';
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
