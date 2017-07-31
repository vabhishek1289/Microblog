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
	<link rel="stylesheet" href="css/main-menu-style.css" charset="utf-8">
  <link href="css/style_3.css" rel="stylesheet">
  <link href="css/microPost.css" rel="stylesheet">
  <style media="screen">
  .follow-btn,.unfollow-btn {
    width: 40px;
    height: 40px;
    position: absolute;
    font-size: 1.25em;
    right: 10px;
    bottom: 40px;
    background: #0ad;
    color: #fff;
    font-weight: bold;
    cursor:pointer;
    border-radius: 50%;
    padding-left: 14px;
    padding-top: 9px;
    box-shadow: 0 0 4px 2px rgba(0, 0, 0, 0.1);
    text-shadow: 1px 2px 2px rgba(5, 0, 0, 0.5);
  } .unfollow-btn {
    background: #f26;
  }
  .post {
    width: 180px;
    font-size: 1em;
  }
  .post-content ul {
    list-style: none;
    padding: 0px;
    color: #999;
  }
  .post-content {
    padding: 10px;
  }
  .post-bottom {
    height: auto;
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
				<li class="item" ><a class="dropdown" id="modal1" href="#"><span class="icon glyphicon glyphicon-download-alt"></span><span class="menu-text">Download <span class="glyphicon glyphicon-plus"></span></span></a></li>
				<ul class="modal1 dropdown-item">
					<a href="home.html"><li><span class="icon glyphicon glyphicon-download-alt"></span><span class="menu-text">Download</span></li></a>
					<a href="#"><li><span class="icon glyphicon glyphicon-download-alt"></span><span class="menu-text">Download</span></li></a>
					<a href="#"><li><span class="icon glyphicon glyphicon-download-alt"></span><span class="menu-text">Download</span></li></a>
				</ul>
				<li class="item"><a href="index.php"><span class="icon glyphicon glyphicon-home"></span><span class="menu-text">Home</span></a></li>
				<li class="item"><a class="dropdown" id="modal2" href="#"><span class="icon glyphicon glyphicon-download-alt"></span><span class="menu-text">Download <span class="glyphicon glyphicon-plus"></span></span></a></li>
				<ul class="modal2 dropdown-item">
					<a href="#"><li><span class="icon glyphicon glyphicon-download-alt"></span><span class="menu-text">Downldad</span></li></a>
					<a href="#"><li><span class="icon glyphicon glyphicon-download-alt"></span><span class="menu-text">Downldad</span></li></a>
					<a href="#"><li><span class="icon glyphicon glyphicon-download-alt"></span><span class="menu-text">Downldad</span></li></a>
					<a href="#"><li><span class="icon glyphicon glyphicon-download-alt"></span><span class="menu-text">Downldad</span></li></a>
					<a href="http://www.google.com"><li><span class="icon glyphicon glyphicon-download-alt"></span><span class="menu-text">Downldad</span></li></a>
				</ul>
				<li class="item"><a href="logout_user.php"><span class="icon glyphicon glyphicon-cog"></span><span class="menu-text">LogOut</span></a></li>
			</ul>
		</div>
	</div>
  <div id="masonry" class="list post-box col-lg-12 col-sm-12">
<!-- TODO: SAMPLE POST TO DELETE -->
<?php
  if(isset($_GET['qft'])) {
    if(!empty($_GET['qft'])) {
      $inrelation = 'following';
      $for_user = $_GET['qft'];
    } else {
      header("Location: sign_in_up.php");
    }
  }
  else if(isset($_GET['qfb'])) {
    if(!empty($_GET['qfb'])) {
      $inrelation = 'follower';
      $for_user = $_GET['qfb'];
    } else {
      header("Location: sign_in_up.php");
    }
  }
  else {
    header("Location: sign_in_up.php");
  }
?>
<!-- TODO: Sample post to delete -->
    <input class="C-end" value="2" type="hidden" />
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

  $('body').on('click','.follow-btn',function () {
    var x = this;
    var a = $('.follow-btn').find('input[name=followId]').val();
  //  alert(a);
    $.post("follow_unfollow.php",
    {
        follow_id: a
    },
    function(data, status){
        if(data=='done') {
          $(x).html('U-<input type="hidden" value="'+a+'" name="followId">');
          $(x).addClass('unfollow-btn');
          $(x).removeClass('follow-btn');
          return;
        }
    });
  });

  $('body').on('click','.unfollow-btn',function () {
    var x = this;
    var a = $('.unfollow-btn').find('input[name=followId]').val();
  //  alert(a);
    $.post("follow_unfollow.php",
    {
        unfollow_id: a
    },
    function(data, status){
    //  alert(data);
        if(data='done') {
          $(x).html('F+ <input type="hidden" value="'+a+'" name="followId">');
          $(x).removeClass('unfollow-btn');
          $(x).addClass('follow-btn')
          return;
        }
    });
  });

    $(window).load(function () {
      $('#cover').hide();
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

    $(window).on('load',function () {
      var remainRows = 1;
      //remainRows = $('.C-end:last').val();
      var forUser = '<?php echo $for_user; ?>';
      var inRelation = '<?php echo $inrelation; ?>';
      var currentRows = $('.post').length;
      if(remainRows > 0) {
        $.post("follow_to_by.php",
        {
          limit_start: currentRows,
          use_for: inRelation,
          user_id: forUser
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
          var forUser = '<?php echo $for_user; ?>';
          var inRelation = '<?php echo $inrelation; ?>';
          var currentRows = $('.post').length;
          if(remainRows > 0) {
            $.post("follow_to_by.php",
            {
              limit_start: currentRows,
              use_for: inRelation,
              user_id: forUser
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
  </script>
</body>
</html>
