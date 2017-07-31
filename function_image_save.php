<?php
Class Image_Function {
  public static function san_str($text) {
    require 'connection.inc.php';
     return addslashes((mysqli_real_escape_string($con,trim($text))));
  }
  public static function delete_image($post_id) {
    if(!empty($post_id)) {
      require 'connection.inc.php';
      $query = "select image_path from images where post_id='$post_id'";
      if($res = $con->query($query)) {
          while($row = $res->fetch_assoc()) {
            if(unlink($row['image_path'])) {
                $query = "delete from images where image_path='".$row['image_path']."'";
                if($con->query($query)) {

                }
            }
          }
      }
    }
  }
  public static function single_image_delete($image_id) {
    if(!empty($image_id)) {
        $query = "delete from images where image_path='$image_id'";
        require 'connection.inc.php';
        if($con->query($query)) {
          if(unlink($image_id)) {
            echo 'done';
          }
        }
    }
  }
  public static function upload_image($images,$user_id,$relation,$tags) {
    $user_id = Image_Function::san_str($user_id);
    $relation = Image_Function::san_str($relation);
    $tags = Image_Function::san_str($tags);
    $dir = 'images';
    $today = getdate();
    if(is_dir($dir)) {
      $dir = $dir.'/'.$today['year'];
      if(!is_dir($dir)) {
        mkdir($dir);
      }
      $dir = $dir.'/'.$today['mon'];
      if(!is_dir($dir)) {
        mkdir($dir);
      }
      $dir = $dir.'/'.$today['mday'];
      if(!is_dir($dir)) {
        mkdir($dir);
      }
      if(is_dir($dir)) {
        $count = count($images['image']['name']);
        for ($i=0; $i < $count; $i++) {
          //echo $name = time().'_'.$images['image']['name'][$i].'<br>';
          $size = $images['image']['size'][$i];
          if($size==0 or $size > 2500000) {
            $count = 0;
          }
          if ($size==0 ) {
            return;
          }
        }
        if($count>=1) {
          for ($i=0; $i < $count; $i++) {
            $name_org = Image_Function::san_str($images['image']['name'][$i]);
            $name = $dir.'/'.time().'_'.$images['image']['name'][$i];
            $size = $images['image']['size'][$i];
            $temp_name = $images['image']['tmp_name'][$i];
            $type = $images['image']['type'][$i];
            $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
            $detectedType = exif_imagetype($images['image']['tmp_name'][$i]);
            if(!in_array($detectedType, $allowedTypes)) {
                echo '<script>alert("Not an Image")</script>';
            } else {
              if($detectedType == IMAGETYPE_JPEG) {
                $im = imagecreatefromjpeg($temp_name);
                imagejpeg($im,$name);
                imagedestroy($im);
              }
              else if($detectedType == IMAGETYPE_PNG) {
                $im = imagecreatefrompng($temp_name);
                imagealphablending($im, true); // setting alpha blending on
                imagesavealpha($im, true);
                imagepng($im,$name);
                imagedestroy($im);
              } else if($detectedType == IMAGETYPE_GIF) {
                $im = imagecreatefromgif($temp_name);
                imagegif($im,$name);
                imagedestroy($im);
              }
              $query = "INSERT INTO `images`(`post_id`, `image_path`, `image_name`, `image_alt`, `relation`) VALUES ('$user_id','$name','$name_org','$tags','$relation')";
              require 'connection.inc.php';
              if($con->query($query)) {
                  echo '<script>alert("Image Uploaded")</script>';
              }
              else {
                echo '<script>alert("Image Not Uploaded")</script>';
              }
            }
          }
        } else {
          echo '<script>alert("Size is must below 2.25Mib or not 0")</script>';
        }
      }
    }
  }
}
