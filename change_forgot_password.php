<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Forget password page to change password</title>
  </head>
  <body>
    Loading please wait .....
    <?php
        if(isset($_POST['email'])&&isset($_POST['email_submit'])) {
          require 'connection.inc.php';
          $email = mysqli_real_escape_string($con,strtolower(trim($_POST['email'])));
          if(!empty($email)) {

            $query = "select username from users where username='$email'";
            if($res = $con->query($query)) {
              if($res->num_rows == 1) {
                require 'functions.inc.php';
                $rand_pass = chr(rand(97,122)).chr(rand(35,38)).chr(rand(97,122)).mt_rand(1000,9999);
                $rand_pass = str_shuffle($rand_pass);                
                if(Helper::forgot_password_mail($rand_pass,$email)) {
                  echo 'mail sent';
                  $hash_pass = md5($rand_pass);
                  $query = "update users set password='$hash_pass' where username='$email'";
                  if($con->query($query)) {
                    header('Location:index.php');
                  }
                  else {
                    echo 'Error occured try again in a while! :(';
                  }
                }
                else {
                  echo 'mail not sent';
                }
              }
              else {
                echo 'username not exist';
              }
            }
          } else {
            echo 'Error of not a mail';
          }
        }
        else {
          header('Location: index.php');
        }
      ?>
  </body>
</html>
