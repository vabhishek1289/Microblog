<?php
session_start();
if(!isset($_SESSION['first_timer'])) {
  header('Location:sign_in_up.php');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Welcome to Login Page</title>
    <noscript>
  <META HTTP-EQUIV="Refresh" CONTENT="0;URL=ShowErrorPage.html">
</noscript>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<title>Project Home Page Template</title>
  	<link href="css/bootstrap.min.css" rel="stylesheet">
  	<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.google.com/?selection.family=Arima+Madurai">
    <style media="screen">
    @import 'https://fonts.googleapis.com/css?family=Aref+Ruqaa|Dancing+Script|Poiret+One|Raleway|Satisfy|Shadows+Into+Light';
      body {
        font-family: 'Satisfy', cursive;
        font-family: 'Dancing Script', cursive;
        background: linear-gradient(90deg,white 25%,#f0f0f0 25%);
        background: url("http://eskipaper.com/images/collage-wallpaper-5.jpg");/*url('http://www.withcompassion.com.au/thank-yououd.jpg');*/
        background-size: 100% ;
        background-repeat: repeat-x;
      }
      .form {
        position: relative;
        padding-top: 1%
      }
      .form input[type=text]{
        position: relative;
        font-size: 1.5em;
        padding-left: 10px;
        width: 100%;
        height: 50px;
        border: 2px solid rgba(0, 0, 0, 0.5);;
        margin-bottom: 15px;
        box-shadow: 0 0 5px 5px rgba(0, 0, 0, 0.1);
        color: #02c1d6;
      }
      .form .submit_btn {
        position: fixed;
        bottom: 30px;
        right: -50px;
        z-index: 100;
      }
      .form input[type=submit]  {
        height: 80px;
        width: 80px;
        border-radius: 50%;
        border: 0px;
        color: white;
        background: #13d2e7;
        font-size: 1.5em;
        box-shadow: 0 0 4px 4px rgba(0, 0, 0, 0.05);
      }
      .form h1 {
        font-size: 1.9em;
        color: rgba(255, 255,255, 0.95);
        margin-left: 10%;
      }
      .form h1 strong {
        color: rgba(256, 256, 256, 1);
      }
      .choice-box {
        width: 100%;
        padding: 0px;
        /*border: 1px solid blue;*/
      }
      .choice-box .category {
        font-family: 'Poiret One', cursive;
        position: relative;
        width: 150px;
        height: 150px;
        margin: 1px;
        font-size: 2em;
        color: black;
        background: white;
        border: 1px solid black;
        padding: 45px;
      }
      .category-checked {
        font-family: 'Poiret One', cursive;
        position: relative;
        width: 150px;
        height: 150px;
        margin: 1px;
        font-size: 2em;
        color: black;
        background: lightgray;
        border: 1px solid gray;
        padding: 45px;
      }
      .tint {
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0px;
        left: 0px;
        background: rgba(0, 0, 0, 0.5);
      }
      @media screen and (max-width: 768px) {
        body {
          background-attachment: scroll;
          background-size: cover;
        }
        .category-checked {
          width: 48%;
          margin-bottom: 2%;
        }
        .choice-box .category {
          width: 48%;
        }
      }
    </style>
  </head>
  <body>
    <div class="tint">

    </div>
    <div class="col-lg-12">
      <?php
      if(isset($_POST['interests'])&&isset($_POST['firstname'])&&isset($_POST['lastname'])) {
        $f_name = $_POST['firstname'];
        $l_name = $_POST['lastname'];
        $interests = $_POST['interests'];
        if(!empty($f_name)&&!empty($l_name)&&!empty($interests)) {
          $interests = explode(", ",$interests);
          if(count($interests)<=2) {
              echo "<script>alert('Please select atleast 2 Choices!!');</script>";
          } else {
            require 'connection.inc.php';
            require 'functions.inc.php';
            // TODO: Query to make user permanent
            $hashed_password = Helper::san_string($_SESSION['hashed_password']);
            $created_on = Helper::san_string($_SESSION['created_on']);
            $gender = Helper::san_string($_SESSION['gender']);
            $username = Helper::san_string($_SESSION['first_timer']);
            $query = "insert into users (username,firstname,lastname,password,created_on,gender) values('$username','$f_name','$l_name','$hashed_password','$created_on','$gender')";
            if($con->query($query)) {
              $query = "delete from archive_user where username='$username' or (timediff(now(),created_on)>'20:00:00' and status = 0)";
              if($con->query($query)) {
                  echo "<script>alert('Registration Done!!')</script>";
                  $check = 1;
                  for ($i=0; $i < count($interests)-1; $i++) {
                    $query = "insert into interests values('$username','$interests[$i]')";
                    if($con->query($query)) {
                      $check = 0;
                    } else
                      $check = 1;
                  }
                  if($check===0) {
                    echo "<script>alert('Registration Done!!')</script>";
                    $_SESSION = array();
                    session_destroy();
                    header("Location: sign_in_up.php");
                  }
                  else {
                    echo "<script>alert('OOps, Error Occured Try again later!!')</script>";
                  }
              }
            } else {
              echo "<script>alert('OOps, Error Occured Try again later!!')</script>";
            }
          }
        } else {
          echo "<script>alert('please fill all the filled!!');</script>";
        }
      }
      ?>

      <form class="form" action="welcome_user.php" method="post">
        <h1>Hello <strong><?php echo $_SESSION['first_timer'];?></strong>, Tell us something about you, </h1>
        <div class="col-lg-2 col-md-2 col-sm-1">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-5">
          <input type="text" name="firstname" value="" maxlength="50" placeholder="First Name">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-5">
          <input type="text" name="lastname" value="" maxlength="50" placeholder="Last Name">
        </div>
        <input type="hidden" name="interests" value="">
        <div class="submit_btn col-lg-2 col-md-2 col-sm-4 col-xs-6">
          <input type="submit" name="name" value="Start">
        </div>
        <div class="col-lg-12">
          <h1>Select atleat 2 or more Segments...</h1>
        </div>
      </form>
      <div id="masonry" class="choice-box col-lg-12">
        <?php
        require 'connection.inc.php';
          $query = "select category from category";
          if($result = $con->query($query)) {
            if($result->num_rows != 0) {
              while($category = $result->fetch_assoc()) {
                  echo "<div class='category'>
                    <input type='hidden'  value='".$category['category']."'>
                    ".$category['category']."
                  </div>";
              }
            }
          }
        ?>
      </div>
    </div>
    <script src="js/jquery-3.0.0.min.js"></script>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  	<script src="js/bootstrap.min.js"></script>
    <script src="js/masonry.pkgd.min.js" charset="utf-8"></script>
    <script type="text/javascript">
    var selection = '';
    var container = document.querySelector('#masonry');
      var masonry = new Masonry(container, {
        columnWidth: 5,
        itemSelector: '.category'
      });
      $('.category').click(function () {
        var s = $(this).find('input[type=hidden]').val();
        $(this).toggleClass('category');
        $(this).toggleClass('category-checked');
      });
      $('input[type=submit]').click(function () {
        $('.category-checked').each(function () {
          selection = selection + $(this).find('input[type=hidden]').val()+', ';
        });
        //alert(selection);
        $('input[name=interests]').val(selection);
      });
    </script>
  </body>
</html>
