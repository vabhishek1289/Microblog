<?php
require 'connection.inc.php';
session_start();
$query = "delete from online where user_id='".$_SESSION['session_user_id']."'";
if($con->query($query)) {
  session_destroy();
  header('Location: sign_in_up.php');
}
