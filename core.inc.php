<?php

ob_start();
session_start();
$current_file=$_SERVER['SCRIPT_NAME'];
if(@isset($_SERVER['HTTP_REFERER'])&&!empty($_SERVER['HTTP_REFERER'])){
	$http_referer=$_SERVER['HTTP_REFERER'];
}

function loggedin(){
	if(@isset($_SESSION['session_user_id'])&&!empty($_SESSION['session_user_id'])){
	return true;
	}
	else{
		return false;
	}
}

function getuserfield($field){
	$query="SELECT `$field` FROM `users` WHERE `username`='".$_SESSION['session_user_id']."'"; 
	if($query_run=@mysql_query($query)){
		if($query_result=@mysql_result($query_run,0,$field)){
			return $query_result;
		}
	}
}
?>