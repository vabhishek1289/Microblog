<?php
require 'connection.inc.php';
session_start();
if(isset($_SESSION['session_user_id'])) {
    if(isset($_POST['category'])&&isset($_POST['title'])&&isset($_POST['youtube_link'])&&isset($_POST['tags'])&&isset($_POST['location'])&&isset($_POST['post_content'])&&isset($_POST['post_id'])) {
      require 'functions.inc.php';
      require 'functions_text.php';
      $title = Helper::san_string($_POST['title']);
      $youtube_link = Helper::san_string($_POST['youtube_link']);
      $tags = Helper::san_string($_POST['tags']);
      $location = Helper::san_string($_POST['location']);
      $content = Helper::san_string($_POST['post_content']);
      $category = Helper::san_string($_POST['category']);
      $post_id = Helper::san_string($_POST['post_id']);
      if(!empty($title)&&!empty($content)&&!empty($category)&&!empty($post_id)) {
        $posted_by = $_SESSION['session_user_id'];
        //require 'functions_text.php';
        $_link = '';
        $content = Text_Functions::html_decodes($content);
        if(!empty($youtube_link)) {
          $_link = trim(Text_Functions::check_link_youtube($youtube_link));
        }
        if(empty($tags)) {
          $tags = $category;
        }
        $content = addslashes($content);
        echo $query = "update post set content='$content', posted_on=posted_on,title='$title', video_link='$_link', location='$location', tags='$tags', category='$category' where post_id='$post_id' and posted_by='$posted_by'";
        if($con->query($query)) {
            require 'function_image_save.php';
            if(!empty($_FILES))
              Image_Function::upload_image($_FILES,$post_id,'pst_pic',$title.', '.$tags);
            echo '<script>alert("Post Updated!!");</script>';
            header('Location: prof.php?q='.base64_encode($_SESSION['session_user_id']));
        } else {
          echo '<script>alert("Post Not Uploaded!!");</script>';
        }
      } else {
        echo '<script>alert("Title, Content, Category can\'t be empty!!");</script>';
      }
    }
  if(isset($_POST['edit_post_id'])) {
    $edit_post_id = trim($_POST['edit_post_id']);
    if(!empty($edit_post_id)) {
      $query_1 = "select * from post where post_id='$edit_post_id' and posted_by = '".$_SESSION['session_user_id']."'";
      if($result_1 = $con->query($query_1)) {
        if($result_1->num_rows == 1) {
          $row = $result_1->fetch_assoc();
    ?>
    <div class="col-lg-12 login-register">
      <h1 class="page-name">
        <span>Edit Post!</span>
      </h1>
      <form class="form" action="edit_post.php" enctype="multipart/form-data" method="post">
        <input type="hidden" name="post_id" value="<?php echo $edit_post_id;?>" />
        <div class="col-lg-6">
            <input type="text" name="title" maxlength=50  required="" value="<?php echo $row['title'];?>" />
            <label for="title"></label>
            <input type="url" name="youtube_link" placeholder="Youtube link" value="<?php if(!empty($row['video_link'])){ echo 'https://www.youtube.com/watch?v='.$row['video_link'] ;} ?>"/>
            <label for="youtube_link" class="btn-youtube"></label>
            <input type="text" name="tags" value="<?php if(!empty($row['tags'])){ echo $row['tags'] ;} ?>" placeholder="tags eg:(art, lifestyle etc)">
            <label for="tags"></label>
            <select name="category" required="" disabled="true">
              <?php echo "<option value=''>Select Category</option>"; ?>
              <?php
                $query = "select category from category";
                if($result = $con->query($query)) {
                  if($result->num_rows != 0) {
                    while($category = $result->fetch_assoc()) {
                        echo "<option value='".$category['category']."'>".$category['category']."</option>";
                    }
                  }
                }
              ?>
            </select>
            <input type="file" name="image[]" value="" multiple="multiple">
            <span class="file_info">&lt- Upload Image</span>
            <a id="location_set"><div class="checked_btn"><span class="glyphicon glyphicon-ok glyphicon-remove"></span></div></a>
            <input class="location_input" type="hidden" name="location" value="">
            <span class="file_info">Share Location</span>
        </div>
        <div class="col-lg-3">
          <div class="image-list">
            <?php $query_2 = "select * from images where post_id='".$row['post_id']."'";
            if($res = $con->query($query_2)) {
              $img_count = $res->num_rows;
              if( $img_count > 0) {
                while($rows = $res->fetch_assoc()) {
                    echo "<div class='image-cover'><img src='".stripcslashes($rows['image_path'])."' alt='".$rows['image_alt']."'/>";
                    ?>
                      <div class="delete-img-tag"><span class="glyphicon glyphicon-remove"></span></div></div>
                    <?php
                }
              }
            }?>
          </div>
        </div>
        <div class="col-lg-3">
          <textarea name="post_content" placeholder="Content" maxlength=250 spellcheck="" required="" ><?php if(!empty($row['content'])){ echo $row['content'] ;}?></textarea>
          <input type="submit" name="submit" value="Edit">
        </div>
      </form>
    </div>
    <?php
        }
      }
    }
  }
}
 ?>
