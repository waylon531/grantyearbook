<?php
$ini_array= parse_ini_file("config.ini");
$con=mysqli_connect($ini_array['mysqli_connect_HOST'],$ini_array['mysqli_connect_USER'],$ini_array['mysqli_connect_PASS']);
$sql="CREATE DATABASE " . $ini_array['sql_user_pass_db'];
if (mysqli_query($con,$sql))
  {
  echo "Database " . $ini_array['sql_user_pass_db'] . "created successfully<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($con) . "<br>";
  }
$sql="CREATE DATABASE " . $ini_array['sql_files_db'];
if (mysqli_query($con,$sql))
  {
  echo "Database " . $ini_array['sql_files_db'] . " created successfully<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($con) . "<br>";
  }
$sql="CREATE TABLE `files\\` (filename char(64) not null,PRIMARY KEY(filename),uploadedby CHAR(255))";
$con=mysqli_connect($ini_array['mysqli_connect_HOST'],$ini_array['mysqli_connect_USER'],$ini_array['mysqli_connect_PASS'],$ini_array['sql_files_db']);
if (mysqli_query($con,$sql))
  {
  echo "Table files created successfully<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($con) . "<br>";
  }
// Create table
$sql="CREATE TABLE userpass(username char(64) not null,PRIMARY KEY(username),hash CHAR(255),realname CHAR(255))";
$con=mysqli_connect($ini_array['mysqli_connect_HOST'],$ini_array['mysqli_connect_USER'],$ini_array['mysqli_connect_PASS'],$ini_array['sql_user_pass_db']);
// Execute query
if (mysqli_query($con,$sql))
  {
  echo "Table userpass created successfully<br>";
  }
else
  {
  echo "Error creating table: " . mysqli_error($con) . "<br>";
  }

?>
