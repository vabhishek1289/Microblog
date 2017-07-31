<?php
session_start();
  if(isset($_SESSION['session_user_id'])) {
    if(isset($_POST['post_id'])) {
      require 'connection.inc.php';
      $on_post = mysqli_real_escape_string($con,addslashes(trim($_POST['post_id'])));
      $liked_by = mysqli_real_escape_string($con,addslashes(trim($_SESSION['session_user_id'])));
      if(!empty($on_post) && !empty($liked_by)) {
        $query = "insert into likes values('$liked_by','$on_post');";
        if($con->query($query)) {
          $query = "update post set likes=likes+1, posted_on=posted_on where post_id='$on_post'";
          if($con->query($query)) {
            echo 'done';
          }
        }
      }
    }
    if(isset($_POST['unlike_post_id'])) {
      require 'connection.inc.php';
      $on_post = mysqli_real_escape_string($con,addslashes(trim($_POST['unlike_post_id'])));
      $liked_by = mysqli_real_escape_string($con,addslashes(trim($_SESSION['session_user_id'])));
      if(!empty($on_post) && !empty($liked_by)) {
        $query = "delete from likes where for_post_id='$on_post' and liked_by='$liked_by';";
        if($con->query($query)) {
          $query = "update post set likes=likes-1, posted_on=posted_on where post_id='$on_post'";
          if($con->query($query)) {
            echo 'done';
          }
        }
      }
    }
    if(isset($_POST['comment_post_id'])) {
      require 'connection.inc.php';
        $post_id = mysqli_real_escape_string($con,addslashes(trim($_POST['comment_post_id'])));
          ?>
          <div class="total-comments">
            <ul>
              <?php
                $query = "select comment,comment_time,comment_by from comment where post_id='$post_id' order by comment_time desc";
                if($result = $con->query($query)) {
                  while($row = $result->fetch_assoc()) {
                    $comment = $row['comment'];
                    $time = $row['comment_time'];
                    $by = $row['comment_by'];
                    echo "<li>$comment <sub>by:<a href='prof.php?q=".base64_encode($by)."' target='blank'>$by</a> on: $time</sub></li>";
                  }
                }
              ?>
            </ul>
          </div>
          <div class="my-comments">
            <a href="comment_read_more.php?q=<?php echo base64_encode($post_id);?>"><button type="button" class="more-comment"><span class=" glyphicon glyphicon-share-alt"></span></button></a>
            <textarea name="comment_content" rows="8" cols="40"></textarea>
            <input type="hidden" name="for_post" value="<?php echo $_POST['comment_post_id']?>"/>
            <input type="submit" name="name">
            <script type="text/javascript">
              $('input[type=submit]').click(function () {
                forPost = $(this).parent().find('input[type=hidden]').attr('value');
                a = this;
                postContent = $(a).parent().find('textarea').val();
                if(postContent.length !=0 ) {
                  $.post("post_comment.php",
                  {
                      comment_post_id: forPost,
                      post_content: postContent
                  },
                  function(data, status){
                    //x = $(a).parent().parent().find('ul').html();
                    if(data=='done') {
                      $(a).parent().parent().find('ul').prepend('<li>'+postContent+'</li>');
                      $(a).parent().find('textarea').val('');
                    }
                  });
                } else {
                  alert('Write a Comment');
                }
                //alert(a);
              });
            </script>
          </div>
          <?php
          echo '<button type="button" class="comment-close"><span class="glyphicon glyphicon-remove"></span></button>';
    }
  }
?>
