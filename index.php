<?php
require 'connection.inc.php';
require 'functions.inc.php';
ob_start();
session_start();
if(!Helper::loggedin()) {
  header("Location: sign_in_up.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Project Home Page Template</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
	<link href="css/style_2.css" rel="stylesheet">
	<link href="css/microPost.css" rel="stylesheet">
	<link rel="stylesheet" href="css/main-menu-style.css" charset="utf-8">
  <link rel="stylesheet" href="css/animate.min.css">
  <link href="css/style_3.css" rel="stylesheet">
  <link href="css/style_31.css" rel="stylesheet">
  <style media="screen">
      .forget-pass {
        background: #f77;
        margin: 10px;
        float: right;
        color: white;
      }
      .form-box-forget {
        width: 100%;
        height: 200px;
        padding: 15px;
      }
      .form-box-forget select {
        margin-top: 20px;
        width: 100%;
        height: 45px;
        font-size: 1.3em;
        border: 0px;
        border-bottom: 2px solid #0ba;
      }
      .form-box-forget input[type=submit] {
        margin-top: 20px;
        width: 100px;
        height: 40px;
        font-size: 1.3em;
        border: 0px;
        background: #0ba;
        color: white;
      }
      .modal-header {
        background: #0ba;
      }
    </style>
</head>
<body>
  <?php
    if(isset($_POST['category'])&&isset($_POST['title'])&&isset($_POST['youtube_link'])&&isset($_POST['tags'])&&isset($_POST['location'])&&isset($_POST['post_content'])) {
      $title = Helper::san_string($_POST['title']);
      $youtube_link = Helper::san_string($_POST['youtube_link']);
      $tags = Helper::san_string($_POST['tags']);
      $location = Helper::san_string($_POST['location']);
      $content = Helper::san_string($_POST['post_content']);
      $category = Helper::san_string($_POST['category']);
      if(!empty($title)&&!empty($content)&&!empty($category)) {
        $posted_by = $_SESSION['session_user_id'];
        $post_id = 'pst_pic_'.$posted_by.'_'.time();
        require 'functions_text.php';
        $_link = '';
        $content = Text_Functions::html_decodes($content);
        if(!empty($youtube_link)) {
          $_link = trim(Text_Functions::check_link_youtube($youtube_link));
        }
        if(empty($tags)) {
          $tags = $category;
        }
        $content = addslashes($content);
        $query = "INSERT INTO `post`(`post_id`, `posted_by`, `content`, `title`, `video_link`, `likes`, `location`, `tags`,`category`) VALUES ('$post_id','$posted_by','$content','$title','$_link',0,'$location','$tags','$category')";
        if($con->query($query)) {
          $query = "update category set count = (count +1) where category='$category'";
          if($con->query($query)) {
            require 'function_image_save.php';
            if(!empty($_FILES))
              Image_Function::upload_image($_FILES,$post_id,'pst_pic',$title.', '.$tags);
            echo '<script>alert("Post Uploaded!!");</script>';
          }
        } else {
          echo '<script>alert("Post Not Uploaded!!");</script>';
        }
      } else {
        echo '<script>alert("Title, Content, Category can\'t be empty!!");</script>';
      }
    }
  ?>
  <div class="menu">
    <div class="menu-open-tag">
      <span class=" glyphicon glyphicon-option-horizontal"></span>
    </div>
    <div class="user_name">
      <?php echo 'welcome, '.$_SESSION['session_user_firstname'] ?>
    </div>
    <div class="menu-brand search-btn">
      <span class="glyphicon glyphicon-search"></span>
    </div>
    <div class="search-menu">
      <form action="" method="post">
          <input type="text" name="search-query" value="" placeholder="Search.." />
          <input type="submit" name="name" value="" />
      </form>
      <div class="search-result">

      </div>
    </div>
    <div class="main-menu">
      <ul class="menu-item">
        <li class="item"><a href="prof.php?q=<?php echo base64_encode($_SESSION['session_user_id']);?>"><span class="icon glyphicon glyphicon-user"></span><span class="menu-text">My Profile</span></a></li>
        <a href='changepass.php?action=cp'><li><span class="icon glyphicon glyphicon-asterisk"></span><span class="menu-text">Change Password</span></li></a>
        <a href='design.php'><li><span class="icon glyphicon glyphicon-envelope"></span><span class="menu-text">Chat</span></li></a>
        <a href='note1.php'><li><span class="icon glyphicon glyphicon-file"></span><span class="menu-text">Private Notes</span></li></a>
        <li class="item" ><a class="dropdown" id="modal1" href="#"><span class="icon glyphicon glyphicon-heart"></span><span class="menu-text">Trends <span class="glyphicon glyphicon-plus"></span></span></a></li>
        <ul class="modal1 dropdown-item">
          <?php require 'connection.inc.php';
            $query = 'select category from category order by count desc limit 6';
            if($res = $con->query($query)) {
              while($row = $res->fetch_assoc()) {
                echo '<a href="home.php?ca='.$row['category'].'"><li><span class="menu-text"> '.strtoupper($row['category']).'</span></li></a>';
              }
            }
           ?>
        </ul>
        <li class="item"><a href="index.php"><span class="icon glyphicon glyphicon-home"></span><span class="menu-text">Home</span></a></li>
        <li class="item"><a href="logout_user.php"><span class="icon glyphicon glyphicon-cog"></span><span class="menu-text">LogOut</span></a></li>
      </ul>
    </div>
  </div>
<div  id="users" class="container-fluid col-lg-12 col-sm-12">
	<div class="search-local-post">
		<input class="search" placeholder=" Search local Post" />

    <button type="button" class="btn forget-pass" data-toggle="modal" data-target=".bs-example-modal-sm-1">Autologout</button>




  <div class="modal fade bs-example-modal-sm-1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Pleas Enter time</h4>
                </div>
                <div class="form-box-forget">
                    <select name='timer'>
                      <option value='30'>30 Seconds</option>
                      <option value='60'>1 Minute</option>
                      <option value='300'>5 Minute</option>
                      <option value='600'>10 Minute</option>
                      <option value='1800'>30 Minute</option>
                      <option value='180000000'>Stop</option>
                    </select>
                    <input type="submit" name="email_submit" value="start">
                    <input type="text" disabled ="true"/>
                </div>

            </div>
          </div>
        </div>

	</div>
	<div id="masonry" class="list post-box col-lg-12 col-sm-12">
<!-- TODO: SAMPLE POST TO DELETE -->

<!-- TODO: Sample post to delete -->
    <input class="C-end" value="2" type="hidden" />
	</div>
  <div class="loading-part"></div>
</div>
<a id="demo02" href="#modal-02"><div class="add-post-button"></div></a>
<div class="scroll-up-button">
</div>

<div id="modal-02" class="modal-content">
  <div class="modal-content">
      <div class="col-lg-12 login-register">
        <div class="form-toggle close-modal-02" id="btn-close-modal">
          <span class="glyphicon glyphicon glyphicon-remove"></span>
        </div>
        <h1 class="page-name">
          <span>Post Here!</span>
        </h1>
        <form class="form" action="index.php" enctype="multipart/form-data" method="post">
          <div class="col-lg-6">
              <input type="text" name="title" maxlength=50  required="" placeholder="Title">
              <label for="title"></label>
              <input type="url" name="youtube_link" placeholder="Youtube link"/>
              <label for="youtube_link" class="btn-youtube"></label>
              <input type="text" name="tags" placeholder="tags eg:(art, lifestyle etc)">
              <label for="tags"></label>
              <select name="category" required="">
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
              <span class="file_inf file_info">&lt- Upload Image</span>
              <a id="location_set"><div class="checked_btn"><span class="glyphicon glyphicon-ok glyphicon-remove"></span></div></a>
              <input class="location_input" type="hidden" name="location" value="">
              <span class="file_info">Share Location</span>
          </div>
          <div class="col-lg-6">
            <textarea name="post_content" placeholder="Content" maxlength=250 spellcheck="" required="" ></textarea>
            <input type="submit" name="submit" value="Post!">
          </div>
        </form>
      </div>
  </div>
</div>
<div id="cover"></div>
	<script src="js/jquery-3.0.0.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src='js/masonry.pkgd.min.js'></script>
	<script src="js/index.js" charset="utf-8"></script>
	<script src="js/menu-actions.js" charset="utf-8"></script>
	<script src="js/list.min.js" charset="utf-8"></script>
  <script src="js/animatedModal.min.js"></script>
  <script src="js/script.js" charset="utf-8"></script>
  <script>
  var Timer = 0;

  $('input[name=email_submit]').click(function () {
    var a = $(this).parent().find('select[name=timer]').val();
      setCookie('timer',a,1);
      startTimer();
  });

  setInterval(function () {
    if(getCookie('timer') == '' && getCookie('timer_set') != '') {
      setCookie('timer_set',0,1);
      location.href = 'logout_user.php' // yaha par logout.php open
    } else {
      setCookie('timer',getCookie('timer')-1,1);
      var time = getCookie('timer');
      if(time < 18000) {
        $('input[type=timer]').val(time+' sec');
      } else {
        $('input[type=timer]').val('Stop');
      }
    }
  },1000);

  function startTimer() {
    setCookie('timer_set',24*60*60*1000,1);
  }
    </script>
    <script>
function setCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (cvalue*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}
</script>


  <script type="text/javascript">
  var locationCount = 0;
	$('body').on('click','.location-part-toggle',function () {
		if(locationCount == 0) {
					$(this).parent().find('.location-part').fadeIn();
					locationCount = 1;
		}
		else if(locationCount == 1) {
			$(this).parent().find('.location-part').fadeOut();
			locationCount = 0;
		}
	});

  $(window).load(function(){
    $('#cover').fadeOut(1000);
  })
    var like = 0;
    $('body').on('click','.like',function (event) {
      if($(this).attr('for') != 'liked') {
        //alert($(this).attr('for'));
        setlike(this);
        like = 1;
        return;
      } else if($(this).attr('for') == 'liked') {
        //alert($(this).attr('for'));
        dislike(this);
        like =0;
        return;
      }
    });
    function setlike(e) {
      a = e;
      var postId = $(a).find('input[name=like]').val();
      $.post("like_comment.php",
      {
          post_id: postId
      },
      function(data, status){
          if(data=='done') {
            $(a).find('i').css('color','#f26');
            $(a).attr('for','liked');
            //alert($(a).attr('for'));
            var x = parseInt($(a).find('sub').html()) + 1;
            $(a).find('sub').html(x);
          }
      });
    }
    function dislike(e) {
      a = e;
      var postId = $(a).find('input[name=like]').val();
      $.post("like_comment.php",
      {
          unlike_post_id: postId
      },
      function(data, status){
        if(data=='done') {
          $(a).find('i').css('color','rgba(0,0,0,0.2)');
          $(a).removeAttr('for');
          var x = parseInt($(a).find('sub').html()) - 1;
          $(a).find('sub').html(x);
        }
      });
    }

    var comment=0;
    $('body').on('click','.comment',function (e) {
      if(true) {
        var postId = $(this).find('input[name=comment]').val();
        a =this;
        $.post("like_comment.php",
        {
            comment_post_id: postId
        },
        function(data, status){
            $(a).parent().parent().parent().find('.comment-part').html(data);
            $(a).parent().parent().parent().find('.comment-part').toggleClass('comment-part-off');
        });
      }
    });
    $('body').on('click','.comment-close',function () {
      $(this).parent().toggleClass('comment-part-off');
    });

    $(window).on('load',function () {
      $('#masonry').masonry( 'reloadItems' );
      $('#masonry').masonry( 'layout' );
      $('#masonry').masonry( 'reloadItems' );
      $('#masonry').masonry( 'layout' );
    });

      $('#masonry').masonry( 'reloadItems' );
      $('#masonry').masonry( 'layout' );

    /*$('.total-comments').on('scroll',function () {
      //alert('Scrolled Down'+$(this).prop('scrollHeight'));
      if($(this).scrollTop() >= 123 ) {
        alert('Scrolled Down'+$(this).prop('scrollHeight'));
      }
    });*/
    $(window).on('load',function () {
      var remainRows = 1;
      //remainRows = $('.C-end:last').val();
      var currentRows = $('.post').length;
      if(remainRows > 0) {
        $.post("get_post.php",
        {
            limit_start: currentRows
        },
        function(data, status){
          //alert(data);
            $('#masonry').append(data);
            $('#masonry').masonry( 'reloadItems' );
            $('#masonry').masonry( 'layout' );
            $('#masonry').masonry( 'reloadItems' );
            $('#masonry').masonry( 'layout' );
        });
      }
    });
    $(window).scroll(function() {
      $('#masonry').masonry( 'reloadItems' );
      $('#masonry').masonry( 'layout' );
        if($(window).scrollTop() >= $(document).height() - $(window).height()) {
          var remainRows = 1;
          remainRows = $('.C-end:last').val();
          var currentRows = $('.post').length;
          if(remainRows > 0) {
            $.post("get_post.php",
            {
                limit_start: currentRows
            },
            function(data, status){
                $('#masonry').append(data);
                $('#masonry').masonry( 'reloadItems' );
                $('#masonry').masonry( 'layout' );
                $('#masonry').masonry( 'reloadItems' );
                $('#masonry').masonry( 'layout' );
            });
          }
        }
    });
    $(window).ajaxStart(function(){
      $('.loading-part').show();
    });
    $(window).ajaxComplete(function (){
      $('.loading-part').hide();
      var options = {
    	   valueNames: [ 'post-content','post-poster' ]
    	};
      var userList = new List('users', options);
    });
    var tmpSearch = 0;
    $('.search-btn').click(function () {
      if(tmpSearch == 0) {
        $('.search-menu').fadeIn();
        tmpSearch = 1;
      } else if(tmpSearch == 1) {
        $('.search-menu').fadeOut();
        tmpSearch = 0;
      }
    });

    $('body').on('keyup','input[name=search-query]',function () {
      if($(this).val().length > 0) {
        var searchQuery = $(this).val();
        $.post("search.php",
        {
            squery: searchQuery
        },
        function(data, status){
          $('.search-result').html(data);
          $('.search-result').show();
        });
      } else {
        $('.search-result').hide();
      }
    });

  </script>
  © <a href='https://www.mapbox.com/map-feedback/'>Mapbox</a> © <a href='http://www.openstreetmap.org/copyright'>OpenStreetMap contributors</a>
</body>
</html>
