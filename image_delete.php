<?php
  session_start();
  if(isset($_SESSION['session_user_id'])) {
    if(isset($_POST['image_id_delete'])) {
      $img_id = trim($_POST['image_id_delete']);
      if(!empty($img_id)) {
        require 'function_image_save.php';
        Image_Function::single_image_delete($img_id);
      }
    }
  }
?>
