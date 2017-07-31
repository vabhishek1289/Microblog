<?php
if(isset($_GET['q']))
{
  $user_id = trim(base64_decode($_GET['q']));
  if(!empty($user_id)) {
    $query = "select profile_img from user_profile where email='$user_id'";
    require 'connection.inc.php';
    if($result = $con->query($query)) {
      if($result->num_rows == 1) {
        $img_name  = $result->fetch_assoc()['profile_img'];
        if($img_name != '') {
          $detectedType = exif_imagetype($img_name);
          header ('Content-Type: image/png');
          if($detectedType == IMAGETYPE_JPEG) {
            $im = imagecreatefromjpeg($img_name);
            imagejpeg($im);
            imagedestroy($im);
          } else if($detectedType == IMAGETYPE_PNG) {
            $im = imagecreatefrompng($img_name);
            imagealphablending($im, true); // setting alpha blending on
            imagesavealpha($im, true);
            imagepng($im);
            imagedestroy($im);
          } else if($detectedType == IMAGETYPE_GIF) {
            $im = imagecreatefromgif($img_name);
            imagegif($im);
            imagedestroy($im);
          }
        }
      }
      else {
        $query = "select firstname from users where username = '$user_id'";
        if($result = $con->query($query)) {
          $text = substr(strtoupper($result->fetch_assoc()['firstname']),0,1);
          header ('Content-Type: image/png');
          $im = @imagecreate(200, 200);
          $background = imagecolorallocate($im, 255, 250, 250);
          $text_color = imagecolorallocate($im, 10, 140, 191);
          imagettftext($im, 100, 0, 50, 150, $text_color, 'fonts/TAILLE.ttf' , $text);
          imagepng($im);
          imagedestroy($im);
        }
      }
    }
  }
}
