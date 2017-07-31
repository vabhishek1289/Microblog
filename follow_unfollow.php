<?php
session_start();
require 'connection.inc.php';
  if(isset($_SESSION['session_user_id'])) {
    if(isset($_POST['follow_id'])) {
      $follow_to = trim(addslashes($_POST['follow_id']));
      $follow_by = $_SESSION['session_user_id'];
      if(!empty($follow_to)) {
        $query = "insert into follows values('$follow_by','$follow_to');";
        if($con->query($query)) {
          echo 'done';
        }
      }
    }
    if(isset($_POST['unfollow_id'])) {
      $unfollow_to = trim(addslashes($_POST['unfollow_id']));
      $follow_by = $_SESSION['session_user_id'];
      if(!empty($unfollow_to)) {
        $query = "delete from follows where follow_by = '$follow_by' and follow_to = '$unfollow_to';";
        if($con->query($query)) {
          echo 'done';
        }
      }
    }
  }
?>
