<?php
class Helper {
  public static function san_string($text) {
    require 'connection.inc.php';
     return addslashes((mysqli_real_escape_string($con,trim($text))));
  }
  public static function loggedin() {
     if(isset($_SESSION['session_user_id'])and(isset($_SESSION['session_user_id']))) {
       $query="select * from online where user_ip = '".trim($_SERVER['REMOTE_ADDR'])."'";
       if(!isset($con)) {
         require 'connection.inc.php';
       }
       if($result = $con->query($query)) {
          if($result->num_rows == 0) {
              return true;
              //session_destroy();
          }
          else {
            return true;
          }
       }
       return false;
     } else {
       $query="delete from online where user_ip = '".trim($_SERVER['REMOTE_ADDR'])."'";
       if(!isset($con)) {
         require 'connection.inc.php';
       }
       if($con->query($query)) {
          return false;
       }
       else return false;
    }
  }

  public static function verify_mail($rand_hash,$username) {
    $to  = $username; // note the comma
    // subject
    $subject = 'Your Verification mail.';
    // message
    $message = '<html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
      <title>Verification Mail for Bug Microblog</title>
    </head>
    <body>
    <div style="width: 640px;">
      <div align="left">
        <a href="http://bugblog.esy.es/"><img src="http://bugblog.esy.es/images/buglogo.jpg" height="50" width="100" alt="simply social Bug"></a>
      </div>
      <h1>Welcome '.$username.',</h1>
      <p>Click the link below to verify your account</p>
      <a href="http://bugblog.esy.es/verify_mail.php?c='.$rand_hash.'&v='.base64_encode($username).'" target="blank">Verify Id</a>
    </div>
    </body>
    </html>
    ';

    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Additional headers
    $headers .= "User, ".$username."\r\n";
    $headers .= "From: Bug Team <bugnottoreply@gmail.com>". "\r\n";


    if (!mail($to, $subject, $message, $headers)) {
        echo "alert('Email Not Sent!')";// . $mail->ErrorInfo;
    } else {
        echo "alert('Registration Done! Verification Email sent Please Verify ')";
    }
  }

  // this is seprate mail for forgot password
  public static function forgot_password_mail($rand_pass,$email) {

    // TODO: aaaaaaaaaaaaaaaa
                  $to  = $email; // note the comma
                  // subject
                  $subject = 'Your password has been changed';
                  // message
                  $message = '<html>
                  <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                    <title>Verification Mail from Bug Microblog</title>
                  </head>
                  <body>
                  <div style="width: 640px;">
                    <div align="left">
                    <a href="http://bugblog.esy.es/"><img src="http://bugblog.esy.es/images/buglogo.jpg" height="50" width="100" alt="Bug logo"></a>
                    </div>
                    <h3>Dear, '.$email.'</h3>
                    <p>Here is your new password </p>
                    <h2>'.$rand_pass.'</h2>
                    <small>Please change your password as soon after verifying.</small>
                  </div>
                  </body>
                  </html>
                  ';

                  // To send HTML mail, the Content-type header must be set
                  $headers  = 'MIME-Version: 1.0' . "\r\n";
                  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                  // Additional headers
                  $headers .= "User, ".$email."\r\n";
                  $headers .= "From: Bug Team <bugnottoreply@gmail.com>". "\r\n";
                  // Mail it
                  // TODO: aaaaaaaaaaaaaaaa
    if (!mail($to, $subject, $message, $headers)) {
        return false;
    } else {
        return true;
    }
  }
  // this is above closed ...


}
?>
