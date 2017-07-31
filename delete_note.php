<?php 
require 'connect.inc.php';
require 'core.inc.php';
if(isset($_POST['delete_note_id'])){
              $delete_note_id=$_POST['delete_note_id'];              
              $delete_query="DELETE FROM `bug_notes` WHERE `username`='".getuserfield('username')."' AND `note_id`='$delete_note_id';";
              if(mysql_query($delete_query)) {
              	header("Location:imageload.php");
              } else {
              	echo 'Some error occured!!';
              }
            }

?>