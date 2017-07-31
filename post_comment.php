<?php
session_start();
if(isset($_SESSION['session_user_id'])) {
    if(isset($_POST['comment_post_id'])&&isset($_POST['post_content'])) {
      require 'connection.inc.php';
      $post_id = mysqli_real_escape_string($con,addslashes(trim($_POST['comment_post_id'])));
      $post_content = mysqli_real_escape_string($con,addslashes(trim($_POST['post_content'])));
      require 'functions_text.php';
      $post_content = Text_Functions::html_decodes($post_content);
      $by_user_id = mysqli_real_escape_string($con,addslashes(trim($_SESSION['session_user_id'])));
      $cmt_id = 'cmt_'.$by_user_id.'_'.time();
      $query = "insert into comment values('$cmt_id','$post_id','$post_content',now(),'$by_user_id')";      
      if($con->query($query)) {
        $query = "update post set comments=comments+1, posted_on=posted_on where post_id='$post_id'";
        if($con->query($query)) {
            echo 'done';
        }
      }
    }
}
?>
