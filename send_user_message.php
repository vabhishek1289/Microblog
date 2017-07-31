<?php
session_start();
  if (isset($_SESSION['session_user_id'])) {
    if (isset($_POST['user_id'])&&isset($_POST['message'])) {
      $from_user = $_SESSION['session_user_id'];
      $for_user = base64_decode(trim($_POST['user_id']));
      $msg = trim($_POST['message']);
      if(!empty($msg)&&!empty($for_user)&&!empty($from_user)) {
        $query = "insert into messages values ('$from_user','$for_user','$msg',now(),'text',0)";
        require 'connection.inc.php';
        if($con->query($query)) {
        ?><div class="sent">
            <span><?php echo $msg;?><i><?php echo date('h:i A',time()+(60*60*3+30*60));?></i></span>
          </div><?php
        }
      }
    }
  }
?>
