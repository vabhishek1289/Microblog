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
</head>
<body>

	<?php
	session_start();
		if(isset($_SESSION['session_user_id'])) {
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
			<?php
		}
		else {
			?>
			<div class="menu">
				<div class="menu-open-tag">
					<span class=" glyphicon glyphicon-option-horizontal"></span>
				</div>
				<div class="user_name">
					Welcome, Guest
				</div>
				<div class="main-menu">
					<ul class="menu-item">
						<li class="item"><a href="sign_in_up.php"><span class="icon glyphicon glyphicon-user"></span><span class="menu-text">Sign-In</span></a></li>
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
					</ul>
				</div>
			</div>
			<?php
		}
	?>

<div  id="users" class="container-fluid col-lg-12 col-sm-12">
	<div class="search-local-post">
		<input class="search" placeholder=" Search local Post" />
	</div>
	<div id="masonry" class="list post-box col-lg-12 col-sm-12">
<!-- TODO: SAMPLE POST TO DELETE -->

<!-- TODO: Sample post to delete -->
    <input class="C-end" value="2" type="hidden" />
	</div>
  <div class="loading-part"></div>
</div>
<div class="scroll-up-button">
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
  <script type="text/javascript">
  var topic  = '<?php if(isset($_GET['ca'])) {
    echo $_GET['ca'];
  } else { echo 'all';} ?>';
    $(window).on('load',function () {
      $('#cover').hide();
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
            limit_start_new: currentRows,
            type_for_user: topic
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
              limit_start_new: currentRows,
              type_for_user: topic
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
</body>
</html>
