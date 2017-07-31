<?php
session_start();
if(isset($_SESSION['session_user_id'])) {
  if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['job']) && isset($_POST['status'])) {
    if(isset($_POST['fname'])&&isset($_POST['lname'])) {
      $uidd = $_SESSION['session_user_id'];
      require 'connection.inc.php';
      $fname = mysqli_real_escape_string($con,$_POST['fname']);
      $lname = mysqli_real_escape_string($con,$_POST['lname']);
      $city = mysqli_real_escape_string($con,$_POST['city']);
      $state = mysqli_real_escape_string($con,$_POST['state']);
      $job = mysqli_real_escape_string($con,$_POST['job']);
      $status = mysqli_real_escape_string($con,$_POST['status']);
      $query = "update users set firstname='$fname', lastname='$lname' where username = '$uidd'";

      if($con->query($query)) {
        $query = "select * from user_profile where email='$uidd'";
        if($result = $con->query($query)) {
          if($result->num_rows == 1 ) {
            $row = $result->fetch_assoc();
            if(!empty($status)) {
              $row['profile_status'] = $status;
            }
            if(!empty($city)) {
              $row['city'] = $city;
            }
            if(!empty($job)) {
              $row['profession'] = $job;
            }
            if(!empty($state)) {
              $row['state'] = $state;
            }
            $status = $row['profile_status'];
            $city = $row['city'];
            $state = $row['state'];
            $job = $row['profession'];
            $query = "update user_profile set profile_status = '$status', city='$city', state='$state', profession = '$job' where email = '$uidd'";
            if($con->query($query)) {
              ?>
              <div class="main-name"> <?php echo $fname.' '.$lname.'  &nbsp'; if(true) {?><span class="edit-user-info glyphicon glyphicon-pencil"></span><?php }?></div>
              <div class="user-status"><?php echo $status ?></div>
              <div class="user-from"><?php echo $city.', '.$state ?></div>
              <div class="user-job"><?php echo $job ?></div>
              <?php
            }
          }
          else {
            $query = "insert into user_profile values ('$uidd','$status','$city','$state','$job',null)";
            if($con->query($query)) {
              ?>
              <div class="main-name"> <?php echo $fname.' '.$lname.'  &nbsp'; if(true) {?><span class="edit-user-info glyphicon glyphicon-pencil"></span><?php }?></div>
              <div class="user-status"><?php echo mysqli_real_escape_string($con,$status) ?></div>
              <div class="user-from"><?php echo $city.', '.$state ?></div>
              <div class="user-job"><?php echo stripslashes($job) ?></div>
              <?php
            }
          }
        }
      }
    }
  }
}
