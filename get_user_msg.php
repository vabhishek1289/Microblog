<?php
  session_start();
  if(isset($_SESSION['session_user_id'])) {
    if(isset($_POST['user_id'])) {
      $sender = base64_decode(trim($_POST['user_id']));
      $rec = $_SESSION['session_user_id'];
      $query = "select *,date_format(send_on_time,'%h:%i %p') as mtime from messages where (sender_id = '$rec' and reciver_id ='$sender') or (sender_id = '$sender' and reciver_id ='$rec')  order by send_on_time desc limit 25";
      require 'connection.inc.php';
      $msg_content = '';
      if($result = $con->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $set_type = 'sent';
            $reca = $row['reciver_id'];
            $senda = $row['sender_id'];
            $timeons = $row['send_on_time'];
            $type_m = $row['message_type'];
            $query1 =  "update messages set status = 2, send_on_time=send_on_time where reciver_id='$reca' and sender_id ='$senda' and send_on_time='$timeons' and (status = 1 or status = 0)";
            if($con->query($query1)) {

            }
          if($row['reciver_id'] == $rec) {
            $set_type = 'receive';
          }
        /*  $msg_content =
          '<div class="'.$set_type.'">
            <span>'.$row['message_content'].'<i>'.$row['mtime'].'</i></span>
          </div>'.''.$msg_content;*/
          if($type_m != 'text') {
            $path_main = $row['message_content'];
            if($type_m == 'image') {
              $disp = '<img width="100" src="'.$path_main.'"/>';
            }
            else if($type_m == 'pdf') {
              $disp = '<img width="100" src="https://cdn3.iconfinder.com/data/icons/lexter-flat-colorfull-file-formats/56/pdf-128.png" />';
            }
            $msg_content =
            '<div class="'.$set_type.'">
                <a href="'.$path_main.'"><span>'.$disp.'<i>'.date('h:i A',time()+(60*60*3+30*60)).'</i></span></a>
              </div>'.''.$msg_content;
          }
           else {
             $msg_content =
             '<div class="'.$set_type.'">
               <span>'.$row['message_content'].'<i>'.$row['mtime'].'</i></span>
             </div>'.''.$msg_content;
           }
        }
        echo $msg_content;
      }
    }
  }
  if(isset($_POST['user_id_append'])) {
    $sender = base64_decode(trim($_POST['user_id_append']));
    $rec = $_SESSION['session_user_id'];
    $query = "select *,date_format(send_on_time,'%h:%i %p') as mtime from messages where ((sender_id = '$sender' and reciver_id ='$rec')) and status = 0 order by send_on_time desc limit 25";
    require 'connection.inc.php';
    $msg_content = '';
    if($result = $con->query($query)) {
      while ($row = $result->fetch_assoc()) {
          $set_type = 'sent';
          $reca = $row['reciver_id'];
          $senda = $row['sender_id'];
          $timeons = $row['send_on_time'];
          $type_m = $row['message_type'];
          if($rec != $senda)
          {
            $query1 =  "update messages set status = 2, send_on_time=send_on_time where reciver_id='$reca' and sender_id ='$senda' and send_on_time='$timeons' and (status = 1 or status = 0)";
            if($con->query($query1)) {

            }
          }
        if($row['reciver_id'] == $rec) {
          $set_type = 'receive';
        }
        if($type_m != 'text') {
          $path_main = $row['message_content'];
          if($type_m == 'image') {
            $disp = '<img width="100" src="'.$path_main.'"/>';
          }
          else if($type_m == 'pdf') {
            $disp = '<img width="100" src="https://cdn3.iconfinder.com/data/icons/lexter-flat-colorfull-file-formats/56/pdf-128.png" />';
          }
          $msg_content =
          '<div class="'.$set_type.'">
              <a href="'.$path_main.'"><span>'.$disp.'<i>'.date('h:i A',time()+(60*60*3+30*60)).'</i></span></a>
            </div>'.''.$msg_content;
        }
         else {
           $msg_content =
           '<div class="'.$set_type.'">
             <span>'.$row['message_content'].'<i>'.$row['mtime'].'</i></span>
           </div>'.''.$msg_content;
         }
      }
      echo $msg_content;
    }
  }
 ?>
