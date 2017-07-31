<?php
  session_start();
  if(isset($_SESSION['session_user_id'])) {
    $limit_start = 0;
    if(isset($_POST['limit_start'])&&isset($_POST['use_for'])&&isset($_POST['user_id'])) {
      $limit_start = $_POST['limit_start'];
      $limit_end = $limit_start+25;
      // TODO: LIMIT ADDING AFTER MORE USER
      $use_for = trim($_POST['use_for']);
      $user_id = base64_decode(trim(($_POST['user_id'])));
      if(!empty($use_for)&&!empty($user_id)) {
        if($use_for == 'following') {
          $query = "select follow_to from follows where follow_by = '$user_id' limit $limit_start, $limit_end";
          require 'connection.inc.php';
          if($result = $con->query($query)) {
            $row_count = $result->num_rows;
            while($row = $result->fetch_assoc()) {
              $uid = $row['follow_to'];
              $query1 = "select concat(firstname,' ',lastname) 'name',DATE_FORMAT(created_on,'%h:%i %p %d-%b\'%y ') as created_on, gender from users where username = '$uid'";
              if($res = $con->query($query1)) {
                $row1 = $res->fetch_assoc();
                $name = $row1['name'];
                $created_on = $row1['created_on'];
                $gender = '';
                if($row1['gender']=='M')
                  $gender = 'Male';
                if($row1['gender']=='F')
                  $gender = 'Female';
                  ?>
                  <div class="post">
                    <div class="post-img">
                      <div class="content-type">
                        <img src="no_pic.php?q=<?php echo base64_encode($row['follow_to'])?>" alt="" />
                      </div>
                      <a href="prof.php?q=<?php echo base64_encode($uid)?>"><div class="post-poster">
                        <span>// <?php echo strtoupper($name); ?></span>
                      </div></a>
                    </div>
                    <div class="post-content">
                      Interests in :
                        <ul>
                        <?php
                          $query1 = "select category from interests where user_id='$uid'";
                          if($res = $con->query($query1)) {
                            while($row1 = $res->fetch_assoc()) {
                              echo '<li>'.strtoupper($row1['category']).'</li>';
                            }
                          }
                        ?>
                        </ul>
                      <?php
                        $suid = $_SESSION['session_user_id'];
                        $query1 = "select count(*) as no from follows where follow_by='$suid' and follow_to ='$uid'";
                        if($res = $con->query($query1)) {
                          $row1 = $res->fetch_assoc();
                          if($uid != $_SESSION['session_user_id']) {
                            if($row1['no'] == 1) {
                              echo '<div class="unfollow-btn">
                                U-
                              <input type="hidden" name="followId" value="'.$uid.'">
                              </div>';
                            } else {
                              echo '<div class="follow-btn">
                                F+
                              <input type="hidden" name="followId" value="'.$uid.'">
                              </div>';
                            }
                          }
                        }
                      ?>
                    </div>
                    <div class="post-bottom">
                        <div class="post-bottom-comment">
                          Joined On: <?php echo $created_on ?>
                        </div>
                    </div>
                  </div>
                  <?php
              }
            }
            echo '<input class="C-end" value="'.$row_count.'" type="hidden" />';
          }
        }
        else if($use_for == 'follower') {
          $query = "select follow_by as follow_to from follows where follow_to = '$user_id' limit $limit_start, $limit_end";
          require 'connection.inc.php';
          if($result = $con->query($query)) {
            $row_count = $result->num_rows;
            while($row = $result->fetch_assoc()) {
              $uid = $row['follow_to'];
              $query1 = "select concat(firstname,' ',lastname) 'name',DATE_FORMAT(created_on,'%h:%i %p %d-%b\'%y ') as created_on, gender from users where username = '$uid'";
              if($res = $con->query($query1)) {
                $row1 = $res->fetch_assoc();
                $name = $row1['name'];
                $created_on = $row1['created_on'];
                $gender = '';
                if($row1['gender']=='M')
                  $gender = 'Male';
                if($row1['gender']=='F')
                  $gender = 'Female';
                  ?>
                  <div class="post">
                    <div class="post-img">
                      <div class="content-type">
                        <img src="no_pic.php?q=<?php echo base64_encode($row['follow_to'])?>" alt="" />
                      </div>
                      <a href="prof.php?q=<?php echo base64_encode($uid)?>"><div class="post-poster">
                        <span>// <?php echo strtoupper($name); ?></span>
                      </div></a>
                    </div>
                    <div class="post-content">
                      Interests in :
                        <ul>
                        <?php
                          $query1 = "select category from interests where user_id='$uid'";
                          if($res = $con->query($query1)) {
                            while($row1 = $res->fetch_assoc()) {
                              echo '<li>'.strtoupper($row1['category']).'</li>';
                            }
                          }
                        ?>
                        </ul>
                      <?php
                        $suid = $_SESSION['session_user_id'];
                        $query1 = "select count(*) as no from follows where follow_by='$suid' and follow_to ='$uid'";
                        if($res = $con->query($query1)) {
                          $row1 = $res->fetch_assoc();
                          if($uid != $_SESSION['session_user_id']) {
                            if($row1['no'] == 1) {
                              echo '<div class="unfollow-btn">
                                U-
                              <input type="hidden" name="followId" value="'.$uid.'">
                              </div>';
                            } else {
                              echo '<div class="follow-btn">
                                F+
                              <input type="hidden" name="followId" value="'.$uid.'">
                              </div>';
                            }
                          }
                        }
                      ?>
                    </div>
                    <div class="post-bottom">
                        <div class="post-bottom-comment">
                          Joined On: <?php echo $created_on ?>
                        </div>
                    </div>
                  </div>
                  <?php
              }
            } echo '<input class="C-end" value="'.$row_count.'" type="hidden" />';
          }
        } else {
          echo '<script>alert("Something went wrong!!")</script>';
        }
      }
    }
  }
?>
