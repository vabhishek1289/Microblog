<?php session_start();
if(!isset($_SESSION['session_user_id'])) {
  header('Location: index.php');
}
require 'connection.inc.php';
if(isset($_POST['setImage']) && isset($_POST['submit'])) {
  $img_path = $_POST['setImage'];
  $user_id = $_SESSION['session_user_id'];
  if( ( $_FILES['image']['size'][0] != 0) or !empty($img_path) ) {
    if( $_FILES['image']['size'][0] != 0) {
      require 'function_image_save.php';
        Image_Function::upload_image($_FILES,'prf_pic_'.$user_id,'prf_pic','profile picture of '.$user_id);
      $query = "select image_path from images where post_id = 'prf_pic_".$user_id."' order by image_path desc limit 1";
      if($res = $con->query($query)) {
        if($res->num_rows != 0) {
          $img_path = $res->fetch_assoc()['image_path'];
          echo $query = "select count(*) as count from user_profile where email='$user_id'";
          if($res = $con->query($query)) {
            $count = $res->fetch_assoc()['count'];
            if($count == 0) {
              echo $query = "insert into user_profile (email,profile_img) values ('$user_id','$img_path')";
              if($con->query($query)) {
                header("Location: prof.php?q=".base64_encode($user_id));
                //echo '1 done';
              }
            }elseif ($count == 1) {
              echo $query = "update user_profile  set profile_img = '$img_path' where email='$user_id'";
              if($con->query($query)) {
                header("Location: prof.php?q=".base64_encode($user_id));
                //echo '2 done';
              }
            }
          }
        }
      }
    } else {
      $query = "select count(*) as count from user_profile where email='$user_id'";
      if($res = $con->query($query)) {
        $count = $res->fetch_assoc()['count'];
        if($count == 0) {
          echo $query = "insert into user_profile (email,profile_img) values ('$user_id','$img_path')";
          if($con->query($query)) {
            header("Location: prof.php?q=".base64_encode($user_id));
            //echo '3 done';
          }
        }else if ($count == 1) {
          echo $query = "update user_profile  set profile_img = '$img_path' where email='$user_id'";
          if($con->query($query)) {
            header("Location: prof.php?q=".base64_encode($user_id));
            //echo '4 done';
          }
        }
      } echo 'asdfasdf';
    }
  } else {
    header('Location: index.php?A');
  }
}

if(isset($_POST['edit_post_id'])) {
?>
<div class="col-lg-2">
</div>
<div class="col-lg-8">
  <div class="image-set">
    <div class="image-set-upper">
      <h3>Select From Uploaded Images</h3>
    </div>
    <?php
    $user_id = $_SESSION['session_user_id'];
    $query = "select image_path, image_alt from images where post_id='prf_pic_".$user_id."'";
    if($result = $con->query($query)) {
      $num = $result->num_rows;
      while($row = $result->fetch_assoc()) {
        ?>
        <div class="image-cover image-set-cover">
          <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['image_alt']; ?>" />
          <div class="delete-img-tag"><span class="glyphicon glyphicon-remove"></span></div>
        </div>
        <?php
      }
      if($num == 0) {
        echo '<h1>No Images To show</h1>';
      }
    }
    ?>
    <div class="image-set-lower">
      <h3>Or upload new </h3>
    </div>
  </div>
  <div class="image-upload">
    <form class="" action="profile_image.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="setImage" value="">
      <input type="file" name="image[]" />
      <span>&lt- Upload Image</span>
      <input type="submit" name="submit" value="Upload" />
    </form>
  </div>
</div>
<div class="col-lg-2">
</div>
<?php }
else {
  //header('Location: index.php?b');
} ?>
