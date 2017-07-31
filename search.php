<?php
session_start();
if(isset($_SESSION['session_user_id'])) {
  if(isset($_POST['squery'])) {
    $q = $_POST['squery'];
    if(!empty($q)) {
      require 'connection.inc.php';
      $query = "SELECT post_id,posted_by,content,title,video_link FROM `post` where concat(content,title,tags) like '%$q%' order by (likes*1 + comments*2) desc limit 3;";
      if($result = $con->query($query)) {
        ?>
        <div class="post-search-result">
          <ul>
        <?php
        if($result->num_rows == 0) {
          echo 'Nothing found in Post';
        }
        else {
          while($row = $result->fetch_assoc()) {
            $user_id = $row['posted_by'];
            $post_id = $row['post_id'];
            $img = 0;
            $img_alt = 'post image';
            $query1 = "select image_path, image_alt from images where post_id = '$post_id' limit 1";
            if($res = $con->query($query1)) {
              if($row1 = $res->fetch_assoc()) {
                $img = $row1['image_path'];
                $img_alt =  $row1['image_alt'];
              }
            }
            $content = $row['content'];
            $title = $row['title'];
            ?>
            <a href="prof.php?q=<?php echo base64_encode($user_id);?>" >
                    <li>
                      <div class="post-search">
                        <?php
                            if(!empty($img)) {
                                echo '<img src="'.$img.'" alt="'.$img_alt.'" align="right" />';
                              }
                            echo '<p><b>'.substr($title,0,20).'..<br></b>';
                            echo substr($content,0,35).'....</p>';
                        ?>
                      </div>
                    </li>
                  </a>
            <?php
          }
        }
        ?>
          </ul>
        </div>
        <?php
      }
      $query = "SELECT * FROM `users` e where concat(firstname,' ',lastname) like '$q%' order by (select count(*) from follows where follow_to=e.username) desc limit 3;";
      if($result = $con->query($query)) {
        ?>
        <div class="user-search-result">
          <ul>
        <?php
        if($result->num_rows == 0) {
          echo 'Nothing found in user';
        }
        else {
          while($row = $result->fetch_assoc()) {
            $userId = base64_encode($row['username']);
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            echo '<a href="prof.php?q='.$userId.'" ><li><img src="no_pic.php?q='.$userId.'" alt="Profile Pic of '.$firstname.' '.$lastname.'('.$row['username'].') " />'.$row["firstname"].' '.$row["lastname"].'</li></a>';
          }
        }
        ?>
          </ul>
        </div>
        <?php
      }
      ?>
      <?php
    }
  }
}
?>
