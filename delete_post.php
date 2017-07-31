<?php
  session_start();
  if(isset($_SESSION['session_user_id'])) {
    if(isset($_POST['delete_post_id'])) {
      $post_id = $_POST['delete_post_id'];
      if(!empty($post_id)) {
        require 'connection.inc.php';
        $query = "update category set count = count-1 where category in (select category from post where post_id='$post_id')";
        if($con->query($query)) {
          $query = "delete from post where post_id='$post_id' and posted_by='".$_SESSION['session_user_id']."'";
          if($con->query($query)) {
            require 'function_image_save.php';
            Image_Function::delete_image($post_id);
            header('Location: prof.php?q='.base64_encode($_SESSION['session_user_id']));
          }
        }
      }
    }
  }
?>
