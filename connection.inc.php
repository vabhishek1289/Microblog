<?php
  $host = "localhost";
  $user = "root";
  $password = "";
  $database = "bug";
  @$con = new mysqli($host,$user,$password,$database);
  if (mysqli_connect_errno()) {
      //printf("Connect failed: %s\n", mysqli_connect_error());
      //exit();
      die();
  }
