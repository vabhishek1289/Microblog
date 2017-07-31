<?php
require 'connection.inc.php';
require 'functions.inc.php';
ob_start();
session_start();
if(!Helper::loggedin()) {
  header("Location: sign_in_up.php");
}
if(!isset($_GET['q'])) {
  header("Location: sign_in_up.php");
}
$prof_id = trim(base64_decode( $_GET['q']));
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
  <link rel="stylesheet" href="css/style_3.css" media="screen" title="no title" charset="utf-8">
  <link rel="stylesheet" href="css/style_prof.css" media="screen" title="no title" charset="utf-8">
  <style media="screen">
  .login-register {
    position: fixed;
    background: rgba(0, 0, 0, 0.20);;
    height: 100%;
    width: 99.999%;
  }
  .form-toggle{
    position: absolute;
    top: 2%;
    right: 10px;
    background: #02c1d6;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.05);
    padding: 15px;
    padding-top: 15px;
    font-size: 1.5em;
    color: white;
    z-index: 100;
  }
  .form input[type=submit] {
    position: fixed;
    bottom: 0%;
    right: 10px;
    background: #02d6c1;
    width: 60px;
    height: 60px;
    padding: 10px;
    padding-top: 10px;
    border-radius: 50%;
    box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.05);
    font-size: 1.5em;
    color: white;
    z-index: 100;
  }
  .page-name {
    position: relative;
    top: 0px;
    font-weight: bold;
    width: auto;
    border-left: 5px solid #02c1d6;
    padding-left: 35px;
    color: #fff;
  }
  .form input,.form select{
    height: 50px;
    width: 100%;
    padding-left: 10px;
    margin-bottom: 10px;
    font-size: 1.5em;
    border: 0px;
    border-bottom: 2px solid rgba(14, 185, 192, 0.5);
    transition: all .35s ease-in;
  }
  .form textarea{
    height: 250px;
    width: 100%;
    padding-left: 10px;
    padding-top: 10px;
    font-size: 1.5em;
    border: 0px;
    border-bottom: 2px solid rgba(14, 185, 192, 0.5);
    resize: none;
  }
  .form label[for=youtube_link] {
    position: absolute;
    left: 20px;
  }
  .form label[for=title] {
    position: absolute;
    left: 20px;
    height: 40px;
    width: 40px;
    background-image: url("http://www.miedemaauctioneering.com/wp-content/uploads/2015/12/title-icon-150.png");
    background-size: 40px 40px;
  }
  .form label[for=tags] {
    position: absolute;
    left: 20px;
    height: 40px;
    width: 40px;
    background-image: url("http://icons.iconarchive.com/icons/pixelkit/gentle-edges/128/Tags-Flat-icon.png");
    background-size: 40px 40px;
  }
  .form input[type=text],input[type=url] {
    padding-left: 50px;
  }
  input[type=file] {
    height: 40px;
    width: 40px;
    border-radius: 50%;
    background-image: url("icon_2.jpg");
    text-indent: -1110px;
    background-position: -15px -250px;
    display: inline-block;
    margin-top: 5px;
    border: 1px solid #02c1d6;
  }
  .form .file_info {
    font-size: 1.2em;
    padding-left: 5px;
    color: white;
  }
  .form .btn-youtube {
    margin: 0px;
    padding: 0px;
    height: 40px;
    width: 40px;
    background-image: url("https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTwxOTiYXnXq-K7zCK3liF6LnnmU78QgJPa6cOqb0fdqMK0GMQH_g");
    background-size: 40px 40px;
    text-indent: -9999px;
    display: inline-block;
    margin-top: 5px;
    margin-bottom: 10px;
  }
  .input-set select {
    position: relative;
    height: 50px;
    width: 45%;
    font-size: 1.5em;
    font-weight: bold;
    border: 0px;
    border-bottom: 1px solid black;
    color: #02c1d6;
    margin-bottom: 0px;
  }
  .options {
    margin-bottom: 0px;
  }
  .checked_btn {
    margin-left: 15px;
    padding: 0px;
    display: inline;
  }
  .checked_btn span {
    padding: 3px;
    border: 2px solid #02c1d6;
    color: white;
  }
  .menu .user_name {
    position: absolute;
    font-size: 1.3em;
    right: 10px;
    top:15px;
  }
  .post iframe {
    border: 0px;
    margin: 0px;
    padding: 0px;
    width: 100%;
    height: auto;
  }
  .video a {
    position: relative;
  }
  .video a::after{
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    content: '';
    width: 50px;
    height: 50px;
    background: url("http://media.mybrowseraddon.com/icons/youtube-most-popular64.png");
    background-size: 50px 50px;
  }
  .like, .comment {
    color: gray;
    cursor: pointer;
  }
  .liked{
    color: red;
  }
  .comment-part-off{
    display: none;
  }
  .comment-part {
    position: absolute;
    bottom:80px;
    box-shadow: 0 0 4px 4px rgba(0, 0, 0, 0.2);
    border: 4px solid rgba(0, 0, 0, 0.2);
    width: 100%;
    height: 300px;
    animation: com-mov .30s ease-in 1;
  }
  @keyframes com-mov {
    from {
      background: #02c1d6;
      transform: rotateY(90deg) translateX(150px);
    }
  }
  .total-comments {
    background: #f0f0f0;
    height: 75%;
    width: 100%;
    overflow: hidden;
    border-bottom: 4px solid gray;
    margin-bottom: 0px;
  }
  .my-comments {
    color: rgba(0, 0, 0, 0.5);
    height: 25%;
    width: 100%;
    margin-bottom: 0px;
  }
  .total-comments ul {
    padding: 10px;
    list-style: none;
  }
  .total-comments ul li{
    margin: 5px;
    margin-left: 25px;
    padding: 10px;
    list-style: none;
    border: 0px solid #02c1d6;
    border-left: 2px solid #0cc;
    box-shadow: 0 0 4px 2px rgba(0, 0, 0, 0.05);
    background: white;
    color: #123;
  }
  .my-comments textarea{
    border: 0px;
    border: 4px solid #02c1d6;
    padding-top: 15px;
    padding-left: 10px;
    width: 100%;
    height: 100%;
    resize: none;
    color: #000;
  }
  .my-comments input[type=submit] {
    position: absolute;
    background: #0cc;
    border: 0px;
    right: 10px;
    bottom: 50px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: url("https://www.whatsapp.com/img/faq/en/android/540295e7359befb428169b70517d32a17a759a07.jpg");
    background-size: 50px 50px;
    text-indent:-1000px;
    box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.1);
  }
  .main-part {
    height: 100%;
  }
  .login-register {
    overflow: scroll;
  }
  .edit-something {
    display: none;
    position: absolute;
    bottom: 80px;
    right: 0px;
    background: white;
    width: 350px;
    height: 220px;
    box-shadow: 0 0 4px 4px rgba(0, 0, 0, 0.1);
  }
  .edit-something::after {
    content: '';
    border: 20px solid transparent;
    border-top: 20px solid white;
    position: absolute;
    bottom: -40px;
    left: 85%;
    transform: translateX(-50%);
  }
  .edit-something .main-name {
    margin-top: 10px;
    border-bottom: 2px solid #abc;
    font-size: 1.8em;
    text-align: center;
    color: #888;
  }
  .edit-something .user-status {
    margin: 10px;
    padding-left: 10px;
    padding-right: 10px;
    border-right: 2px solid #abc;
    font-size: 1em;
    text-align: center;
    color: #999;
  }
  .edit-something .user-status::after, .edit-something .user-status::before {
    content: ' \'\' ';
    font-size: 1em;
    color: orange;
  }
  .edit-something .user-from,.user-job {
    color: #999;
    padding-top: 10px;
    padding-right: 10px;
    border-right: 2px solid #abc;
    text-align: right;
    margin: 10px;
  }
  .edit-user-info {
    cursor: pointer;
  }
  .edit-user-info::after {
    font-family: 'Poiret One';
    content: 'Edit';
    font-size: 0.65em;
  }
  .a_p_u_i input[type=text]{
    width: 48%;
    margin: 1%;
    height: 30px;
    border:  0px;
    border-bottom: 2px solid #999;
  }
  .a_p_u_i textarea{
    width: 80%;
    margin: 2%;
    resize: none;
    border: 0px;
    border-bottom: 2px solid #999;
    height: 75px;
  }
  .a_p_u_i input[type=submit] {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width: 40px;
    height: 40px;
    color: white;
    font-weight: bold;
    background: #f66;
    border-radius: 50%;
    border: 0px;
    box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.05);
  }
  .a_p_u_i .close_a_p_u_i {
    position: relative;
    float: right;
    margin: 5px;
    background: #f66;
    border-radius: 50%;
    border: 0px;
    color: white;
    box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.05);
    width: 20px;
    height: 20px;
    padding-left: 6px;
    cursor: pointer;
  }
  </style>
</head>
<body>
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
  <div class="col-lg-1"></div>
  <div class="user-profile col-lg-10">
    <div class="user-background-img">
      <img src="http://cdn.wallpapersafari.com/25/34/Z6L1So.jpg" alt="" />
    </div>
    <div class="tint"></div>
    <div class="user-img">
      <img src="no_pic.php?q=<?php echo base64_encode($prof_id);?>" alt="" />
      <?php
      if($_SESSION['session_user_id'] == $prof_id){
      ?>
      <div class="tint"></div>
      <div class="profile-image-edit"><span class="glyphicon glyphicon-pencil"></span></div>
      <?php
      }
      ?>
    </div>

      <?php
      if($_SESSION['session_user_id'] != $prof_id) {
        $query = "select count(*) as count from follows where follow_to='$prof_id' and follow_by='".$_SESSION['session_user_id']."'";
        if($result = $con->query($query)) {
          if($result->fetch_assoc()['count'] == 0) {
          ?>
          <div class="follow-btn">
          Follow <span class="glyphicon glyphicon-plus"></span>
          <input type="hidden" name="followId" value="<?php echo $prof_id?>">
          </div>
        <?php
      } else {
        ?>
        <div class="unfollow-btn">
        Unfollow <span class="glyphicon glyphicon-minus"></span>
        <input type="hidden" name="followId" value="<?php echo $prof_id?>">
        </div>
        <?php
      }
        } else {
          header("Location: index.php");
        }
      }
      ?>
    <div class="user-info">
      <div>
        <?php
          $f_name = '';
          $l_name = '';
          $query = "select firstname,lastname from users where username='$prof_id'";
          if($result = $con->query($query)) {
            $row = $result->fetch_assoc();
          } else {
            header("Location: index.php");
          }
        ?>
         <span>
           <?php
              $f_name = $row['firstname'];
              $l_name = $row['lastname'];
              echo $row['firstname'].' '.$row['lastname'];
            ?>
        </span>
      </div>
    </div>
    <div class="user-social-info">
      <a href="follows.php?qfb=<?php echo base64_encode($prof_id);?>"><div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <sub>Follower</sub> <br> <?php
          $query = "select count(*) as count from follows where follow_to='$prof_id'";
          if($result = $con->query($query)) {
            $row = $result->fetch_assoc();
            echo $row['count'];
          } else {
            header("Location: index.php");
          }
        ?>
      </div></a>
      <a href="follows.php?qft=<?php echo base64_encode($prof_id);?>"><div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <sub>Following</sub> <br><?php
          $query = "select count(*) as count from follows where follow_by='$prof_id'";
          if($result = $con->query($query)) {
            $row = $result->fetch_assoc();
            echo $row['count'];
          } else {
            header("Location: index.php");
          }
        ?>
      </div></a>
      <div class="more-info-user col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <sub>more..</sub>
      </div>
    </div>
    <?php
      $query = "select * from user_profile where email='$prof_id'";
      if($result = $con->query($query)) {
          $from_loc = '_FROM_WHERE_NOT_AVAIL';
          $status = '_NO_STATUS_';
          $job = '_JOB_DATA_NOT_AVAILABLE';
        if($result->num_rows == 1) {
          $row = $result->fetch_assoc();
          if(!empty($row['city'])or!empty($row['state']))
            $from_loc = $row['city'].', '.$row['state'];
          if(!empty($row['profile_status']))
            $status = $row['profile_status'];
          if(!empty($row['profession']))
            $job = $row['profession'];
        }
        ?>
        <div class="edit-something">
          <div class="main-name"> <?php echo $f_name.' '.$l_name.'  &nbsp'; if($prof_id == $_SESSION['session_user_id']) {?><span class="edit-user-info glyphicon glyphicon-pencil"></span><?php }?></div>
          <div class="user-status"><?php echo $status ?></div>
          <div class="user-from"><?php echo $from_loc ?></div>
          <div class="user-job"><?php echo $job ?></div>
        </div>
        <?php
      }
    ?>
  </div>
  <div class="edit-post-layout">
    <div class="content-edit">

    </div>
    <div class="close-edit-post-layout">
      <span class="glyphicon glyphicon-remove"></span>
    </div>
  </div>
  <div  id="users" class="container-fluid col-lg-12 col-sm-12">
  	<div id="masonry" class="list post-box col-lg-12 col-sm-12">
  <!-- TODO: SAMPLE POST TO DELETE -->

  <!-- TODO: Sample post to delete -->
      <input class="C-end" value="2" type="hidden" />
  	</div>
    <div class="loading-part"></div>
  </div>
  <div id="cover"></div>
	<script src="js/jquery-3.0.0.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src='js/masonry.pkgd.min.js'></script>
	<script src="js/index.js" charset="utf-8"></script>
	<script src="js/menu-actions.js" charset="utf-8"></script>
  <script src="js/script.js" charset="utf-8"></script>
  <script type="text/javascript">
  $('#masonry').masonry( 'reloadItems' );
  $('#masonry').masonry( 'layout' );

    var tmpSearch = 0;
    $('.search-btn').click(function () {
      if(tmpSearch == 0) {
        $('.search-menu').fadeIn();
        tmpSearch = 1;
        return;
      } else if(tmpSearch == 1) {
        $('.search-menu').fadeOut();
        tmpSearch = 0;
        return;
      }
    });
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

        /*$('.total-comments').on('scroll',function () {
          //alert('Scrolled Down'+$(this).prop('scrollHeight'));
          if($(this).scrollTop() >= 123 ) {
            alert('Scrolled Down'+$(this).prop('scrollHeight'));
          }
        });*/
        $(window).on('load',function () {
          var remainRows = 1;
          //remainRows = $('.C-end:last').val();
          userIdForPost = '<?php echo  base64_encode($prof_id);?>';
          var currentRows = $('.post').length;
          if(remainRows > 0) {
            $.post("user_post.php",
            {
                limit_start: currentRows,
                user_id_for_post: userIdForPost
            },
            function(data, status){
              // alert(data);
                $('#masonry').append(data);
                $('#masonry').masonry( 'reloadItems' );
                $('#masonry').masonry( 'layout' );
                $('#masonry').masonry( 'reloadItems' );
                $('#masonry').masonry( 'layout' );
            });
          }
        });

        $(window).scroll(function() {
            if($(window).scrollTop() >= $(document).height() - $(window).height()) {
              var remainRows = 1;
              remainRows = $('.C-end:last').val();
              userIdForPost = '<?php echo  base64_encode($prof_id);?>';
              var currentRows = $('.post').length;
              if(remainRows > 0) {
                $.post("user_post.php",
                {
                    limit_start: currentRows,
                    user_id_for_post: userIdForPost
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

        $('body').on('click','.follow-btn',function () {
          var a = $('.follow-btn').find('input[type=hidden]').val();
          $.post("follow_unfollow.php",
          {
              follow_id: a
          },
          function(data, status){
              if(data=='done') {
                $('.follow-btn').html('Unfollow <span class="glyphicon glyphicon-minus"></span><input type="hidden" value="'+a+'" name="followId">');
                $('.follow-btn').addClass('unfollow-btn');
                $('.unfollow-btn').removeClass('follow-btn');
                return;
              }
          });
        });
        $('body').on('click','.unfollow-btn',function () {
          var a = $('.unfollow-btn').find('input[type=hidden]').val();
          $.post("follow_unfollow.php",
          {
              unfollow_id: a
          },
          function(data, status){
              if(data='done') {
                $('.unfollow-btn').html('Follow <span class="glyphicon glyphicon-plus"></span><input type="hidden" value="'+a+'" name="followId">');
                $('.unfollow-btn').addClass('follow-btn')
                $('.follow-btn').removeClass('unfollow-btn');
                return;
              }
          });
        });

        $('body').on('click','.edit-post',function () {
          var d = $(this).find('span').attr('for');
          $.post("edit_post.php",
          {
              edit_post_id: d
          },
          function(data, status){
            //alert(data);
              $('.edit-post-layout').find('.content-edit').html(data);
          });
          $('.edit-post-layout').fadeIn();
          $('body').css('overflow','hidden');
        });
        $('body').on('click','.close-edit-post-layout',function () {
          $('.edit-post-layout').fadeOut();
          $('body').css('overflow','auto');
        });

        $('body').on('click','.delete-img-tag',function () {
          var imgId = $(this).parent().find('img').attr('src');
          var d=this;
          $.post("image_delete.php",
          {
              image_id_delete: imgId
          },
          function(data, status){
            $(d).parent().hide();
          });
        });

        $('body').on('click','.delete-post',function () {
          var d = $(this).find('span').attr('for');
          var tx = confirm('Are you sure want to delete this post?');
          if(tx == true) {
            $.post("delete_post.php",
            {
                delete_post_id: d
            },
            function(data, status){
              //alert(data);
            });
          } else if(tx == false) {
          }
        });
        $('body').on('click','.profile-image-edit',function () {
          $.post("profile_image.php",
          {
              edit_post_id: 1
          },
          function(data, status){
              $('.edit-post-layout').find('.content-edit').html(data);
          });
          $('.edit-post-layout').fadeIn();
          $('body').css('overflow','hidden');
        });
        var tempImgSet = 0;
        $('body').on('click','.image-set-cover', function () {
          if(tempImgSet == 0)
          {
            var setImgId = $(this).find('img').attr('src');
            $(this).css('opacity','.65');
            $(this).parent().parent().find('input[name=setImage]').val(setImgId);
            var a = $(this).parent().parent().find('input[name=setImage]').val();
            //alert(a);
            tempImgSet = 1;
            return;
          } else if(tempImgSet == 1) {
            $(this).parent().parent().find('input[name=setImage]').val('');
            $(this).css('opacity','1');
            tempImgSet = 0;
            return;
          }
        });

        $('body').on('click','.more-info-user',function () {
          var x = $('.edit-something').css('display');
          if(x == 'none') {
            $('.edit-something').fadeIn('fast','swing');
          }
          else {
            $('.edit-something').fadeOut();
          }
        });
        var a_x = '';
        $('body').on('click','.edit-user-info',function () {
          var a = this;
          a_x = $(this).parent().parent().html();
          var y = '<div class="a_p_u_i"><div class="close_a_p_u_i">x</div><input type="text" name="fname" required="" value="<?php echo $f_name?>" placeholder="First Name"/><input type="text" name="lname" required="" value="<?php echo $l_name?>" placeholder="Last Name"/><input type="text" name="city" placeholder="City"/><input type="text" name="state" placeholder="State"/><input type="text" name="profession" placeholder="Profession"/><textarea name="status" placeholder="Status ....115 characters Only" maxlength="115"></textarea><input class="a_p_u_i_submit" type="submit" name="submit" value="edit"></div>';
          $(this).parent().parent().html(y);
        });
        $('body').on('click','.close_a_p_u_i',function () {
            $(this).parent().parent().html(a_x);
        });

        $('body').on('click','.a_p_u_i_submit',function () {
          var m_d = this;
          var fname = $(this).parent().find('input[name=fname]').val();
          var lname = $(this).parent().find('input[name=lname]').val();
          var city = $(this).parent().find('input[name=city]').val();
          var state = $(this).parent().find('input[name=state]').val();
          var job = $(this).parent().find('input[name=profession]').val();
          var status = $(this).parent().find('textarea[name=status]').val();
          if((fname.length > 0)&&(lname.length > 0)&&(status.length < 115 )) {
            $.post("edit_user_info.php",
            {
                fname: fname,
                lname: lname,
                city: city,
                state: state,
                job: job,
                status: status
            },
            function(data, status){
              $(m_d).parent().parent().html(data);
            });
          } else {
            alert('First and Last name Can\'t be empty!!');
          }
        });

        /**********COMMON JS SCRIPT FOR SEARCH**********/
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
</body>
</html>
