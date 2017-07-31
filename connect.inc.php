<?php

$mysql_host='localhost';
$mysql_user='root';
$mysql_pass='';
$mysql_error='Could not connect to DB';
$mysql_db='bug';
if((!@mysql_connect($mysql_host,$mysql_user,$mysql_pass))||(!@mysql_select_db($mysql_db))){
die($mysql_error);	
}
else{
//echo "Connected...";
}
?>