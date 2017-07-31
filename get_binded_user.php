<?php
  session_start();
  if(isset($_SESSION['session_user_id'])) {
    if(isset($_POST['for_user_id'])) {
      if(base64_decode(trim($_POST['for_user_id'])) == $_SESSION['session_user_id']) {
        $user_id = $_SESSION['session_user_id'];
        $query = "select follow_to from follows where follow_by='$user_id' and follow_to in (select follow_by from follows where follow_to= '$user_id');";
        require 'connection.inc.php';
        echo '<ul>';
        if($result = $con->query($query)) {
          while ($row = $result->fetch_assoc()) {
            $uid = $row['follow_to'];
            $query1 = "select concat(firstname,' ',lastname) as name from users where username='$uid'";
            if($result1 = $con->query($query1)) {
                $r = $result1->fetch_assoc();
                ?>
                <li class="user-chat-open"><img src="no_pic.php?q=<?php echo base64_encode($uid);?>" alt="" /><input type="hidden" name="userId" value="<?php echo base64_encode($uid)?>"><?php echo $r['name']; ?></li>
                <?php
            }
          }
        }
        echo '</ul>';
      }
    }
  }
?>
