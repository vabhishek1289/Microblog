<?php
  if(isset($_GET['v'])&&isset($_GET['c'])) {
    $username = trim(base64_decode($_GET['v']));
    $code = ($_GET['c']);
    if(!empty($username)and!empty($code))
    {
      require 'connection.inc.php';
      // TODO: throw error if username is out of time limit
      $query = 'select * from archive_user where username="'.$username.'" and check_code="'.$code.'" and (timediff(now(),created_on) < "20:00:00" or status = 1)';
      if($result = $con->query($query)) {
        if($result->num_rows == 1) {
          $temp_data = $result->fetch_assoc();
          //print_r($temp_data);
          $username = trim($temp_data['username']);
          $hashed_password = $temp_data['password'];
          $created_on = $temp_data['created_on'];
          $gender = $temp_data['gender'];
        if(trim($temp_data['status'])!=1) {
          $query = "update archive_user set status=1 where username='$username' and check_code='$code'";
          if($con->query($query)) {
            session_start();
            $_SESSION['hashed_password']=$hashed_password;
            $_SESSION['created_on'] = $created_on;
            $_SESSION['gender'] = $gender;
            $_SESSION['first_timer']=$username;
            header('Location:welcome_user.php');
          }
        } else {
          echo '<h1>Already verified User';
          session_start();
          $_SESSION['hashed_password']=$hashed_password;
          $_SESSION['created_on'] = $created_on;
          $_SESSION['gender'] = $gender;
          $_SESSION['first_timer']=$username;
          header('Location:welcome_user.php');
        }
        } else {
          $query = "select * from users where username='$username'";
          if($result = $con->query($query)) {
            if($result->num_rows == 1) {
              echo '<h1>Already verified User!';
              header("Location: sign_in_up.php");
            } else {
              echo '<h1>Username NOT exist(May be deleted if not verified for long time) try again to <a href="sign_in_up.php">signUP!</a>';
            }
          }
        }
      }
    }
    else {
      echo '<h1>Some Error Occur, Try again later';
    }
  } else {
    header('Location:sign_in_up.php');
  }
 ?>
