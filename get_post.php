<?php
session_start();
  if(isset($_SESSION['session_user_id'])) {
    $limit_start = 0;
    if(isset($_POST['limit_start'])) {
      $user_id = $_SESSION['session_user_id'];
      $limit_start = $_POST['limit_start'];
      $limit_end = $limit_start+4;
      $query = "select *,date_format(posted_on,'%Y') 'year',date_format(posted_on,'%b/%d') 'date',date_format(posted_on,'%r') 'time'  from post where posted_by in (select follow_to from follows where follow_by='$user_id') or (posted_by='$user_id') and (datediff(now(),posted_on) < 2) order by posted_on desc limit $limit_start,$limit_end";
      require 'connection.inc.php';
      $row_count = 0;
      if($result = $con->query($query)) {
        $row_count = $result->num_rows;
        while($row = $result->fetch_assoc()) {
        ?>
        <div class="post">
          <div class="post-img">
            <div class="post-date">
              <span class="post-year"><?php echo $row['year']?></span>
              <span class="post-day"><?php echo $row['date']?></span>
            </div>
            <div class="content-type">
              <?php if(!empty($row['video_link'])) {
                ?><div class="video">
                  <a href="https://www.youtube.com/embed/<?php echo stripcslashes($row['video_link']);?>?rel=0&amp;controls=0&amp;showinfo=0"><img src="https://i.ytimg.com/vi/<?php echo $row['video_link'];?>/hqdefault.jpg" alt="" /></a>
                </div>
                <?php
                }
                $img_count = 0;
                $query_1 = "select * from images where post_id='".$row['post_id']."'";
                if($res = $con->query($query_1)) {
                  $img_count = $res->num_rows;
                  if( $img_count > 0) {
                    while($rows = $res->fetch_assoc()) {
                        echo "<img src='".stripcslashes($rows['image_path'])."' alt='".$rows['image_alt']."'/>";
                    }
                  } else {
                    echo '<div class="content-null-image"></div>';
                  }
                  if(!empty($row['location'])) {
                    ?>
                    <img class="location-part" src="https://api.mapbox.com/v4/mapbox.run-bike-hike/pin-m-camera+025a64(<?php echo $row['location']?>)/<?php echo $row['location']?>,14/350x250@2x.png?access_token=pk.eyJ1IjoiYWRpdHlhdmFzaGlzaHRoYSIsImEiOiJjaXBjOGt0bW8wMDd3dTBuaXJ0bzZka295In0.SN-dG4LEDz4muIf7p7HoIA" alt="" />
                    <div class="location-part-toggle"></div>
                    <?php
                  }
                }
              ?>
            </div>
            <div class="post-poster">
              <img src="no_pic.php?q=<?php echo base64_encode($row['posted_by']);?>" alt="" />
              <?php
                $query_1 = "select firstname from users where username='".$row['posted_by']."'";
                if($res = $con->query($query_1)) {
                  $rows = $res->fetch_assoc();
                  //echo "<span>".strtoupper(stripcslashes($rows['firstname']))."</span>";
                  echo "<a style='color:white;' href='prof.php?q=".base64_encode($row['posted_by'])."'><span>// ".strtoupper($rows['firstname'])."</span></a>";
                }
              ?>
            </div>
          </div>
          <div class="post-content">
            <p>
              <a href="#"><?php echo stripcslashes($row['title']) ?></a>
            </p>
            <?php echo stripcslashes(stripcslashes($row['content'])) ?>
          </div>
          <div class="post-readmore">
            <div class="social-sharing">
              <?php
                $query_1 = "select liked_by from likes where for_post_id = '".$row['post_id']."' and liked_by ='".$_SESSION['session_user_id']."'";
                if($res = $con->query($query_1)) {
                  $isliked = $res->num_rows;
                  if($isliked == 1) {
                      echo '<a class="like" for="liked"><input type="hidden" name="like" value="'.$row['post_id'].'"/><i style="color:#f26;" class="glyphicon glyphicon-heart-empty"></i><sub>'.$row['likes'].'</sub></a>';
                  } else {
                      echo '<a class="like"><input type="hidden" name="like" value="'.$row['post_id'].'"/><i class="glyphicon glyphicon-heart-empty"></i><sub>'.$row['likes'].'</sub></a>';
                  }
                }
              ?>
              <a class="comment"><input type="hidden" name="comment" value="<?php echo $row['post_id']?>"/><i class="glyphicon glyphicon-comment"></i> <sub><?php echo $row['comments'];?></sub> </a>
            </div>
          </div>
          <div class="post-bottom">
              <div class="post-bottom-comment">
                <?php echo $row['time'] ?>
              </div>
          </div>
          <div class="comment-part comment-part-off" role="pst_pic_adityakamal@outlook.com_1471248693">

          </div>
        </div>
        <?php
        }
        $limit_start = $_POST['limit_start'];
        $limit_end = $limit_start + 5;
        $query = "select *,date_format(posted_on,'%Y') 'year',date_format(posted_on,'%b/%d') 'date',date_format(posted_on,'%r') 'time'  from post where category in (select category from interests where user_id='$user_id') and (datediff(now(),posted_on)<15) and posted_by not in (select follow_to from follows where follow_by='$user_id') and (posted_by!='$user_id') order by (date_format(posted_on,'%d')*10+likes+comments*2) desc limit $limit_start,$limit_end";
        if($result = $con->query($query)) {
          $row_count = $row_count + $result->num_rows;
          while($row = $result->fetch_assoc()) {
          ?>
          <div class="post">
            <div class="post-img">
              <div class="post-date">
                <span class="post-year"><?php echo $row['year']?></span>
                <span class="post-day"><?php echo $row['date']?></span>
              </div>
              <div class="content-type">
                <?php if(!empty($row['video_link'])) {
                  ?><div class="video">
                    <a href="https://www.youtube.com/embed/<?php echo $row['video_link'];?>?rel=0&amp;controls=0&amp;showinfo=0"><img src="https://i.ytimg.com/vi/<?php echo $row['video_link'];?>/hqdefault.jpg" alt="" /></a>
                  </div>
                  <?php
                  }
                  $img_count = 0;
                  $query_1 = "select * from images where post_id='".$row['post_id']."'";
                  if($res = $con->query($query_1)) {
                    $img_count = $res->num_rows;
                    if( $img_count > 0) {
                      while($rows = $res->fetch_assoc()) {
                          echo "<img src='".$rows['image_path']."' alt='".$rows['image_alt']."'/>";
                      }
                    } else {
                      echo '<div class="content-null-image"></div>';
                    }
                    if(!empty($row['location'])) {
                      ?>
                      <img class="location-part" src="https://api.mapbox.com/v4/mapbox.run-bike-hike/pin-m-camera+025a64(<?php echo $row['location']?>)/<?php echo $row['location']?>,14/300x250@2x.png?access_token=pk.eyJ1IjoiYWRpdHlhdmFzaGlzaHRoYSIsImEiOiJjaXBjOGt0bW8wMDd3dTBuaXJ0bzZka295In0.SN-dG4LEDz4muIf7p7HoIA" alt="" />
                      <div class="location-part-toggle"></div>
                      <?php
                    }
                  }
                ?>
              </div>
              <div class="post-poster">
                <img src="no_pic.php?q=<?php echo base64_encode($row['posted_by']);?>" alt="" />
                <?php
                  $query_1 = "select firstname from users where username='".$row['posted_by']."'";
                  if($res = $con->query($query_1)) {
                    $rows = $res->fetch_assoc();
                    echo "<a style='color:white;' href='prof.php?q=".base64_encode($row['posted_by'])."'><span>// ".strtoupper($rows['firstname'])."</span></a>";
                  }
                ?>
              </div>
            </div>
            <div class="post-content">
              <p>
                <a href="#"><?php echo stripcslashes(stripcslashes($row['title'])) ?></a>
              </p>
              <?php echo stripcslashes(stripcslashes($row['content'])) ?>
            </div>
            <div class="post-readmore">
              <div class="social-sharing">
                <?php
                  $query_1 = "select liked_by from likes where for_post_id = '".$row['post_id']."' and liked_by ='".$_SESSION['session_user_id']."'";
                  if($res = $con->query($query_1)) {
                    $isliked = $res->num_rows;
                    if($isliked == 1) {
                        echo '<a class="like" for="liked"><input type="hidden" name="like" value="'.$row['post_id'].'"/><i style="color:#f26;" class="glyphicon glyphicon-heart-empty"></i><sub>'.$row['likes'].'</sub></a>';
                    } else {
                        echo '<a class="like"><input type="hidden" name="like" value="'.$row['post_id'].'"/><i class="glyphicon glyphicon-heart-empty"></i><sub>'.$row['likes'].'</sub></a>';
                    }
                  }
                ?>
                <a class="comment"><input type="hidden" name="comment" value="<?php echo $row['post_id']?>"/><i class="glyphicon glyphicon-comment"></i> <sub><?php echo $row['comments'] ?></sub></a>
              </div>
            </div>
            <div class="post-bottom">
                <div class="post-bottom-comment">
                  <?php echo $row['time'] ?>
                </div>
            </div>
            <div class="comment-part comment-part-off" role="pst_pic_adityakamal@outlook.com_1471248693">

            </div>
          </div>
          <?php
          }
          echo '<input class="C-end" value="'.$row_count.'" type="hidden" />';
        }
      }
    }
  }
 // for non registered user this will show post general ...
  $limit_start = 0;
  if(isset($_POST['limit_start_new'])&&isset($_POST['type_for_user'])) {
    $_POST['limit_start'] = $_POST['limit_start_new'];
    $cat = '';
    if($_POST['type_for_user'] == 'all' ) {
      $cat = '';
    } else {
      $cat =' category = \''.$_POST['type_for_user'].'\' and ';
    }
    $limit_start = $_POST['limit_start'];
    $limit_end = $limit_start+10;
    $query = "select *,date_format(posted_on,'%Y') 'year',date_format(posted_on,'%b/%d') 'date',date_format(posted_on,'%r') 'time' from post where $cat (datediff(now(),posted_on) < 102) order by (date_format(posted_on,'%d')*10+likes+comments*2) desc limit $limit_start,$limit_end";
    require 'connection.inc.php';
    $row_count = 0;
    if($result = $con->query($query)) {
      $row_count = $result->num_rows;
      while($row = $result->fetch_assoc()) {
      ?>
      <div class="post">
        <div class="post-img">
          <div class="post-date">
            <span class="post-year"><?php echo $row['year']?></span>
            <span class="post-day"><?php echo $row['date']?></span>
          </div>
          <div class="content-type">
            <?php if(!empty($row['video_link'])) {
              ?><div class="video">
                <a href="https://www.youtube.com/embed/<?php echo stripcslashes($row['video_link']);?>?rel=0&amp;controls=0&amp;showinfo=0"><img src="https://i.ytimg.com/vi/<?php echo $row['video_link'];?>/hqdefault.jpg" alt="" /></a>
              </div>
              <?php
              }
              $img_count = 0;
              $query_1 = "select * from images where post_id='".$row['post_id']."'";
              if($res = $con->query($query_1)) {
                $img_count = $res->num_rows;
                if( $img_count > 0) {
                  while($rows = $res->fetch_assoc()) {
                      echo "<img src='".stripcslashes($rows['image_path'])."' alt='".$rows['image_alt']."'/>";
                  }
                } else {
                  echo '<div class="content-null-image"></div>';
                }
                if(!empty($row['location'])) {
                  ?>
                  <img class="location-part" src="https://api.mapbox.com/v4/mapbox.run-bike-hike/pin-m-camera+025a64(<?php echo $row['location']?>)/<?php echo $row['location']?>,14/350x250@2x.png?access_token=pk.eyJ1IjoiYWRpdHlhdmFzaGlzaHRoYSIsImEiOiJjaXBjOGt0bW8wMDd3dTBuaXJ0bzZka295In0.SN-dG4LEDz4muIf7p7HoIA" alt="" />
                  <div class="location-part-toggle"></div>
                  <?php
                }
              }
            ?>
          </div>
          <div class="post-poster">
            <img src="no_pic.php?q=<?php echo base64_encode($row['posted_by']);?>" alt="" />
            <?php
              $query_1 = "select firstname from users where username='".$row['posted_by']."'";
              if($res = $con->query($query_1)) {
                $rows = $res->fetch_assoc();
                //echo "<span>".strtoupper(stripcslashes($rows['firstname']))."</span>";
                echo "<a style='color:white;' href='prof.php?q=".base64_encode($row['posted_by'])."'><span>// ".strtoupper($rows['firstname'])."</span></a>";
              }
            ?>
          </div>
        </div>
        <div class="post-content">
          <p>
            <a href="#"><?php echo stripcslashes($row['title']) ?></a>
          </p>
          <?php echo stripcslashes(stripcslashes($row['content'])) ?>
        </div>
        <div class="post-readmore">

        </div>
        <div class="post-bottom">
            <div class="post-bottom-comment">
              <?php echo $row['time'] ?>
            </div>
        </div>
        <div class="comment-part comment-part-off" role="pst_pic_adityakamal@outlook.com_1471248693">

        </div>
      </div>
      <?php
      }
    }
  }
?>
