<?php
session_start();
if (isset($_SESSION['session_user_id'])) {
  if (isset($_POST['for_user_id'])) {
    $for_user = strtolower(base64_decode(trim($_POST['for_user_id'])));
    if($for_user == strtolower($_SESSION['session_user_id'])) {
      $query = "select *,date_format(send_on_time,'%h:%i %p') as time,date_format(send_on_time,'%d-%m-%Y') as date_on from messages m where (m.sender_id='$for_user' or m.reciver_id = '$for_user') and m.send_on_time in (select max(send_on_time) from messages m1 where (m1.sender_id = m.sender_id and m1.reciver_id=m.reciver_id) or (m1.reciver_id = m.sender_id and m1.sender_id = m.reciver_id )) order by send_on_time desc";
      require 'connection.inc.php';
      if($res = $con->query($query)) {
        echo '<ul>';
        while ($row = $res->fetch_assoc()) {
          $mtype = '';
          if($row['status'] == 0) {
            $mtype = 'not-seen';
          }
          if(date('d-m-Y',time() + (60*60*3+30*60)) == $row['date_on']) {
            $row['date_on'] = 'Today';
          } else if(date('d-m-Y',(time() + (60*60*3+30*60)) - 24*60*60) == $row['date_on']) {
            $row['date_on'] = 'Yesterday';
          }
          if($for_user == strtolower($row['sender_id'])) {
            $msg_id = strtolower($row['reciver_id']);
            $query1 = "select concat(firstname) name from users where username='$msg_id'";
            if($re = $con->query($query1)) {
              $row1 = $re->fetch_assoc()['name'];
            }
            ?>
              <li class="user-chat-open"><img src="no_pic.php?q=<?php echo base64_encode($msg_id);?>" alt="" /><input type="hidden" name="userId" value="<?php echo base64_encode($msg_id)?>" for="<?php echo $row1; ?>" /><?php echo '<b> Me: </b>'.substr($row['message_content'],0,20).'...'; ?><i><?php echo $row['time'];?> <span><?php echo $row['date_on'];?></span></i></li>
            <?php
          } else {
            $msg_id = strtolower($row['sender_id']);
            $query1 = "select concat(firstname) name from users where username='$msg_id'";
            if($re = $con->query($query1)) {
              $row1 = $re->fetch_assoc()['name'];
            }
            ?>
              <li class="user-chat-open<?php echo ' '.$mtype; ?>"><img src="no_pic.php?q=<?php echo base64_encode($msg_id);?>" alt="" /> <input type="hidden" name="userId" value="<?php echo base64_encode($msg_id)?>" for="<?php echo $row1; ?>" /><?php echo '<b> '.$row1.': </b>'.substr($row['message_content'],0,20).'..' ;?><i><?php echo $row['time'];?> <span><?php echo $row['date_on'];?></span></i></li>
            <?php
          }
        }
        echo "</ul>";
      }
    }
  }
}
?>
