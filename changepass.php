<?php
require 'connection.inc.php';
require 'functions.inc.php';
ob_start();
session_start();
if(!Helper::loggedin()) {
  header("Location: sign_in_up.php");
}
?>
<html>
<head>
    <meta charset="utf-8">
        <link href="change.css" rel="stylesheet" />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<link rel="stylesheet" href="css/bootstrap.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>

<?php
if($_GET['action']=="cp")
{
	echo "<div class='container'>
			 <div class='card card-container'>
			   <img id='profile-img' class='profile-img-card' src='no_pic.php?q=".base64_encode($_SESSION['session_user_id'])."' />
            <p id='profile-name' class='profile-name-card'></p>
			<form action='changepass.php?action=cp' method='POST'>";

	echo "<div class='form-group'>
					<label><span class='glyphicon glyphicon-lock'></span>Current Password</label>
					<input type='password' name='curr_pass' class='form-control' placeholder='Current Password'>
		  </div>
		 <div class='form-group'>
					<label><span class='glyphicon glyphicon-log-out'></span><span>New Password</span></label>
					<input type='password' name='new_pass' class='form-control' placeholder='New Password'>
		  </div>
		 <div class='form-group'>
					<label><span class='glyphicon glyphicon-new-window'></span>Confirm Password</label>
					<input type='password' name='conf_pass' class='form-control' placeholder='Confirm Password'><br>
		  </div>";
    echo " <button class='btn btn-sm btn-success' type='submit' name='submit'>Save Changes</button>
    </div>
    </div>";

    $curr_pass=@$_POST['curr_pass'];
    $new_pass=@$_POST['new_pass'];
    $conf_pass=@$_POST['conf_pass'];
	    
	    if(isset($_POST['submit']))
	    {
			$query="select * from users where username='".$_SESSION['session_user_id']."'";
			if($result = $con->query($query))
			{
				while ($row=$result->fetch_assoc())
				{
					$ori_pass= $row['password'];
				}
				   if(md5($curr_pass)==$ori_pass)
				   {
				   	 if(strlen($new_pass)>6)
				   	 {
				   		if($conf_pass==$new_pass)
				   		{
				   			$query="update users set password='".md5($new_pass)."' where username='".$_SESSION['session_user_id']."'";
				   			if($result = $con->query($query))
							{
								header("Location:index.php");
								echo "<script>alert('Password Changed');</script>";
				   			}

					   	}else
					   	{
					   		echo "<script>alert('Password doesn't match');</script>";
					   	}
						
					 }
					 else
					 {
						 echo "<script>alert('Password must be more than 6 characters');</script>";
					 }		
				   }
				   else
				   {
					   echo "<script>alert('Enter valid current password');</script>";
				   }
			
		    }
	    }	
	echo "</form>";
}

?>
</html>

