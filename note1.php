<?php

require 'core.inc.php';
require 'connect.inc.php';
require 'connection.inc.php';
require 'functions.inc.php';

if(!Helper::loggedin()) {
  header("Location: sign_in_up.php");
}
//include 'index.php';

if(loggedin()){

	if(
	isset($_POST['title'])||
	isset($_POST['textarea'])||
	isset($_POST['deadline'])||
	isset($_POST['priority1'])&&
	isset($_POST['image_name'])
	//isset($_POST['done'])
	){    
		$note_title=mysqli_real_escape_string($con,htmlentities($_POST['title']));
		$note_text=mysqli_real_escape_string($con,htmlentities($_POST['textarea']));
		$deadline=$_POST['deadline'];
		$priority=$_POST['priority1'];
	$note_image_name=mysqli_real_escape_string($con,htmlentities($_POST['image_name']));
		//$task_completed=$_POST['done'];
		//$i_name= addslashes($_FILES['image']['name']);
		//$image = addslashes($_FILES['image']['tmp_name']);


		if(
		(!empty($note_text)||
		!empty($deadline)||
		!empty($priority)||
		!empty($note_image_name))&&
		(!empty($note_title))

		//!empty($i_name))
		//!empty($task_completed)
		){
				$year_upload=date("Y");
				$month_upload=date("m");
				$target_dir="uploads/"."$year_upload"."/"."$month_upload"."/";
				if(!@file_exists($target_dir)){
				@mkdir($target_dir,0777,true);
				}
				if(basename($_FILES["image"]["name"])){$target_file=$target_dir .date_timestamp_get(date_create())."_".getuserfield('username')."_". basename($_FILES["image"]["name"]);}
				else {$target_file=NULL;}
				$uploadOk=1;
				$imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);


				$check=@getimagesize($_FILES["image"]["tmp_name"]);
				if(@$check!== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk=1;
				} else {
					//echo "File is not an image.";
					$uploadOk=0;
				}

			// Check if file already exists
			if (@file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk=0;
			}
			// Check file size
			if (@$_FILES["image"]["size"]>1000000) {
				echo "Sorry, your file is too large.";
				$uploadOk=0;
			}
			// Allow certain file formats
			if(@$imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
				//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk=0;
			}
			// Check if $uploadOk is set to 0 by an error
			if (@$uploadOk==0) {
				//echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
				if(@move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}












				//$image = file_get_contents($image);
				//$image = base64_encode($image);
				//$max_file_size=$_FILES['image']['size'];

				$note_id="";
				$query_count=mysql_query("SELECT count(username) AS count from bug_notes WHERE `username`='".getuserfield('username')."';");
				$data=mysql_fetch_assoc($query_count);
				$note_id=getuserfield('username')."_".$data['count'];

				$username=getuserfield('username');
				if(isset($_POST['done'])){
					$task_completed=$_POST['done'];
				}
				else{
					$task_completed=0;
				}

				$start_date=date("Y/m/d");
				//if($max_file_size>1000000){
					//echo "Max File Size is 1mb";
				//}
				//else {
				$query="INSERT INTO `bug_notes` VALUES ('$username','$note_id','$note_title','$note_text','$start_date','$deadline','$priority','$task_completed','$note_image_name','$target_file')";
				if($query_run=mysql_query($query)){
						header('Location:note1.php');

						}
						else{
							echo mysql_error();
							echo "Could not update to database";
						}

				//}
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<link rel="stylesheet" href="css/bootstrap.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  <style>
  body
  {

    background: url("book.jpg");
    background-size:100%;


}

  .modal-header,.close {
      background-color: #5cb85c;
      color:white;
      text-align: center;
      font-size: 30px;
  }
  #priority{
  	margin:50px;
  }
  #home{
  	margin:50px;
  }

  </style>


</head>

<body>

	<div class="container">
	<h1 style="color: white;">Welcome to Private Note</h1><br>

	 <span> <button type="button" class="btn btn-success" id="btnTrigger" data-toggle="modal" data-target="#popUpWindow">Add Your Notes</button></span>
	 <span id="home"> <button type="button" class="btn btn-primary" onclick="location.href='Imageload.php';">See Notes</button></span>
	  <button type="button" class="btn btn-warning" onclick="location.href='index.php';">Back to Home</button>
	  <div class="modal fade" id="popUpWindow">
	  	<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-title"><span class="glyphicon glyphicon-file"></span>Add a Note</span>
	   </div>
				</div>
				<div class="modal-body">
					<form role="form" action="note1.php" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label><span class="glyphicon glyphicon-pencil"></span>Title</label>
							<input type="text" id="title" name="title" class="form-control" placeholder="Your Title Name">
						</div>
						<div class="form-group">
							<label><span class="glyphicon glyphicon-hand-right"></span>Content</label>
							<textarea type="textarea" id="textarea" name="textarea" class="form-control"></textarea>
						</div>
						<div class="form-group">
						    <label><span class="glyphicon glyphicon-calendar"></span>Deadline</label>
							<input type="time" id="deadline" name="deadline" style="border-radius:5px; height:30px; width:120px; ">
							<span id="priority">
							<label><span class="glyphicon glyphicon-chevron-down"></span>Priority</label>
							<select id="priority_1" name="priority1" style="border-radius:5px; height:30px; width:120px">
								<option id="vimp" name="vimp" style="color:#ff2a00">Very Important</option>
								<option id="imp" name="imp" style="color:#ff8c00">Important</option>
								<option id="normal" name="normal" style="color:#32e025">Normal</option>
								<option id="least" name="least" style="color:#2983ff">Least</option>
							</select>
							</span>
						</div>
						<div class="form-group">
							<label><span class="glyphicon glyphicon-paperclip"></span>Image Name(Optional)</label>
							<input class="form-control" id="image_name" name="image_name" placeholder="Image Name">
						</div>
						<div class="form-group">
						<label><span class="glyphicon glyphicon-upload"></span>Select Image</label>
						<input type="file" name="image" id="image">
						</div>
						<div class="form-group">
							<span style="color:red">*</span><span style="font-style:oblique;">Make sure file to be image and less than 1MB<span></span>
						</div>
						 <div class="checkbox">
              				<label><input type="checkbox" id="done" name="done" value="1">Mark as Done</label>
            			</div>

				</div>
				<div class="modal-footer">
					<button type="submit" id="compose" name="compose" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-ok-circle"</span> Compose</button>
					</form>
					<button type="submit"  class="btn btn-danger pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span> Cancel</button>

				</div>
		    </div>
		</div>
	  </div>
	</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>
