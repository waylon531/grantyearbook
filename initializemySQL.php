<?php
$con=mysqli_connect("localhost","user","password");
$sql="CREATE DATABASE userpass";
if (mysqli_query($con,$sql))
  {
  echo "Database userpass created successfully<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($con) . "<br>";
  }
// Create table
$sql="CREATE TABLE userpass(username char(64) not null,PRIMARY KEY(username),hash CHAR(255),realname CHAR(255))";
$con=mysqli_connect("localhost","root","1337haXX0r","userpass");
// Execute query
if (mysqli_query($con,$sql))
  {
  echo "Table userpass created successfully";
  }
else
  {
  echo "Error creating table: " . mysqli_error($con);
  }
?>