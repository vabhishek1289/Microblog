<?php
ob_start();
session_start();
require 'connection.inc.php';
require 'functions.inc.php';
if(Helper::loggedin()) {
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Welcome to Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<title>Project Home Page Template</title>
  	<link href="css/bootstrap.min.css" rel="stylesheet">
  	<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.google.com/?selection.family=Arima+Madurai">
    <link rel="stylesheet" href="css/sign_in_up.css" media="screen" title="no title" charset="utf-8">
    <style media="screen">
      .error_message h4 {
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        padding: 5px;
      }
      .forget-pass {
        background: #f77;
        margin: 10px;
        float: right;
        color: white;
      }
      .form-box-forget {
        width: 100%;
        height: 200px;
      }
      .form-box-forget input[type=text] {
        margin-top: 20px;
        width: 100%;
        height: 45px;
        font-size: 1.3em;
        border: 0px;
        border-bottom: 2px solid #0ba;
      }
      .form-box-forget input[type=submit] {
        margin-top: 20px;
        width: 100px;
        height: 40px;
        font-size: 1.3em;
        border: 0px;
        background: #0ba;
        color: white;
      }
    </style>
  </head>
  <body>
    <div class="error_message">
    </div>
    <div class="col-lg-2">
    </div>
    <div class="col-lg-8 login-register">
      <div class="col-lg-3">
      </div>
      <div class="col-lg-6">
        <div class="form-toggle">
          <span class="glyphicon glyphicon-pencil"></span>
        </div>
        <div class="sign-in">
          <h1 class="page-name">
            <span>Sign in</span>
          </h1>
          <div class="form-content">
            <form  action="sign_in_up.php" method="post">
              <div class="input-set">
                <input type="text" name="email" max-length="250" value="" required="">
                <label for="email">Username</label>
              </div>
              <div class="input-set">
                <input type="password" name="password" max-length="30" value="" required="">
                <label for="password">Password</label>
              </div>
              <div class="input-submit">
                <input type="submit" name="sign_in" value="Go">
              </div>
              <!-- TODO: Add forgot password link -->

              <button type="button" class="btn forget-pass" data-toggle="modal" data-target=".bs-example-modal-sm">Forgot Password</button>
              <?php // TODO: Adding buttong for modeling of forget password ?>

            </form>
          </div>
        </div>

        <?php // TODO: ADDING MODEL FOR FORGOT PASSWORD VAGERAH .... ?>
        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Pleas Enter you EmailID</h4>
                <div class="form-box-forget">
                  <form action="change_forgot_password.php" method="post">
                    <input type="text" name="email" placeholder="Enter your Email.." required="true" />
                    <input type="submit" name="email_submit" value="Submit">
                  </form>
                  <small>A verification mail will be sent to you after submition..</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php // TODO: ADDING MODEL FOR FORGOT PASSWORD VAGERAH .... ?>

        <div class="sign-up">
          <h1 class="page-name">
            <span>Sign Up</span>
          </h1>
          <div class="form-content">
            <form  action="sign_in_up.php" method="post">
              <div class="input-set">
                <input type="email" name="s_up_email" value="" max-length="250" required=""/>
                <label for="email">Email</label>
              </div>
              <div class="input-set">
                <input type="password" name="s_up_password" value="" max-length="30" required=""/>
                <label for="password">Password</label>
              </div>
              <div class="input-set">
                <select name="gender">
                  <option value="M">Male</option>
                  <option value="F">Female</option>
                </select>
                <br>
                <span>By clicking S-Up!, i accept to Terms &amp Conditions</span>
              </div>
              <div class="input-submit">
                <input type="submit" name="sign_up" value="S-UP!">
              </div>
              <!-- TODO: Add forgot password link -->
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-2">
    </div>
    <script src="js/jquery-3.0.0.min.js">
    </script>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  	<script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
    var count = 0;
    $(".form-toggle").click(function () {
      if(count==0) {
        $(".sign-in").hide();
        $(".sign-up").fadeIn();
        count++;
      }
      else if(count==1) {
        $(".sign-in").fadeIn();
        $(".sign-up").hide();
        count--;
      }
    });
    $(".input-set").on("click",function (){
      $(this).find("label").css({"top":"-30px","left":"5px","font-size":"1.3em"});
      $(this).find("input").focus();
      $(this).find("input").css({"border-bottom":"3px solid #02c1d6"});
    });
    $(".input-set").find("input").focus(function (){
      $(this).parent().find("label").css({"top":"-30px","left":"5px","font-size":"1.3em","opacity":"1"});
      $(this).css({"border-bottom":"3px solid #02c1d6"});
    });
    $(".input-set").find("input").focusout(function (){
      if($(this).val() == '') {
        $(this).parent().find("label").css({"top":"15px","left":"5px","font-size":"1.5em","opacity":".5"});
        $(this).css({"border-bottom":"1px solid #000"});
      }
    });
    $(".sign-up").find("input[type=password]").keyup(function () {
      var text = $(this).val();
        if (((text.match(/^[a-z]+$/) != null) || (text.match(/^[0-9]+$/) != null)) || text.length < 7) {
          $(this).css({"border-bottom":"4px solid darkorange"});
          $("input[type=submit]").attr("disabled","true");
          //$(this).parent().find("label").text("Atleast One Character and once number and min 7 length: "+text);
        }
        else  {
          $(this).css({"border-bottom":"3px solid #2f2"});
          $("input[type=submit]").removeAttr("disabled");
        }
    });

    <?php
    if (isset($_POST['sign_in'])) {
      $username = Helper::san_string($_POST['email']);
      $password = Helper::san_string($_POST['password']);
      if(!empty($username)and!empty($password)) {
        $hashed_password = md5($password);
        require 'connection.inc.php';
        $user_ip = Helper::san_string($_SERVER['REMOTE_ADDR']);
        $device_info = Helper::san_string($_SERVER['HTTP_USER_AGENT']);
        $query = "select * from users where (username='$username' and password='$hashed_password')";
        if($result = $con->query($query)) {
          if($result->num_rows==1) {
            $temp = $result->fetch_assoc();
            $query = "select * from online where user_id='$username'";
            if($result = $con->query($query)) {
              if($result->num_rows == 0) {
                $query = "insert into online values ('$username',1,'$user_ip','$device_info',now())";
                if($con->query($query)) {
                  $_SESSION['session_user_id'] = strtolower($username);
                  $_SESSION['session_user_firstname'] = $temp['firstname'];
                  //echo '$(".error_message").html("<h4 style=\"color: red;\">Online USER:-)</h4>")';
                  // TODO: add code to log user in and set some hard values for single system login;;;
                  header("Location: index.php");
                }
                else {
                  echo '$(".error_message").html("<h4 style=\"color: red;\">OOPs, Some error occured :\'(</h4>")';
                }
              } else {
                $query = "delete from online where user_id = '$username'";
                if($con->query($query)) {
                  $query = "insert into online values ('$username',1,'$user_ip','$device_info',now())";
                  if($con->query($query)) {
                    $_SESSION['session_user_id'] = $username;
                    $_SESSION['session_user_firstname'] = $temp['firstname'];
                    //echo '$(".error_message").html("<h4 style=\"color: red;\">Online USER:-)</h4>")';
                    // TODO: add code to log user in and set some hard values for single system login;;;
                    header("Location: index.php?page");
                  }
                  else {
                    echo '$(".error_message").html("<h4 style=\"color: red;\">OOPs, Some error occured :\'(</h4>")';
                  }
                }
                //echo 'location.replace("target.html");';
                // TODO:  add a new page for multiple device logout ;;;;
                //header('Location: multiple_machine_detection.php?v='.base64_encode($username).'');
              }
            }
          }
          else {
            echo '$(".error_message").html("<h4 style=\"color: red;\">Username or Password is incorrect </h4>")';
          }
        }else {
          echo '$(".error_message").html("<h4 style=\"color: red;\">OOPs, Some error occured:-(</h4>")';
        }
      }
      else {
        echo '$(".error_message").html("<h4 style=\"color: red;\">Please fill all fields:-)</h4>")';
      }
    }
    if (isset($_POST['sign_up'])) {
      $email = Helper::san_string($_POST['s_up_email']);
      $password = Helper::san_string($_POST['s_up_password']);
      $gender = Helper::san_string($_POST['gender']);
      if(!empty($email)&&!empty($password)&&!empty($gender)) {
        $hashed_password = md5($password);
        $rand_hash = md5(rand());
        //echo "alert('".$rand_hash."')";
        // TODO: Check for already existing user //-----> Done
        require 'connection.inc.php';
        $query = "select * from users where username='$email'";
        if ($result = $con->query($query)) {
          if($result->num_rows == 0) {
            $query = "insert into archive_user (username,password,gender,check_code,status) values('$email','$hashed_password','$gender','$rand_hash',0)";
            if ($con->query($query)) {
              //echo "alert('Registeration Success')";
              Helper::verify_mail($rand_hash,$email);
              //  $result->close();
            }
          } else {
            echo '$(".error_message").html("<h4 style=\"color: red;\">Email already exists :-(</h4>")';
          }
        }
      }
      else {
        echo '$(".error_message").html("<h4 style=\"color: red;\">Please fill all fields:-)</h4>")';
      }
    }
    ?>
    </script>
  </body>
</html>
