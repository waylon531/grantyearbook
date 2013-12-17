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
$sql="CREATE DATABASE files";
if (mysqli_query($con,$sql))
  {
  echo "Database files created successfully<br>";
  }
else
  {
  echo "Error creating database: " . mysqli_error($con) . "<br>";
  }
// Create table
$sql="CREATE TABLE userpass(username char(64) not null,PRIMARY KEY(username),hash CHAR(255),realname CHAR(255))";
$con=mysqli_connect("localhost","user","password","userpass");
// Execute query
if (mysqli_query($con,$sql))
  {
  echo "Table userpass created successfully<br>";
  }
else
  {
  echo "Error creating table: " . mysqli_error($con) . "<br>";
  }
$con=mysqli_connect("localhost","user","password","files");
$sql="CREATE TABLE current(filename char(64) not null,PRIMARY KEY(filename),uploadedby CHAR(255))";
if (mysqli_query($con,$sql))
  {
  echo "Table current created successfully<br>";
  }
else
  {
  echo "Error creating table: " . mysqli_error($con) . "<br>";
  }
$sql="CREATE TABLE older(filename char(64) not null,PRIMARY KEY(filename),uploadedby CHAR(255))";
if (mysqli_query($con,$sql))
  {
  echo "Table older created successfully<br>";
  }
else
  {
  echo "Error creating table: " . mysqli_error($con) . "<br>";
  }
$sql="CREATE TABLE oldest(filename char(64) not null,PRIMARY KEY(filename),uploadedby CHAR(255))";
if (mysqli_query($con,$sql))
  {
  echo "Table oldest created successfully<br>";
  }
else
  {
  echo "Error creating table: " . mysqli_error($con) . "<br>";
  }
$sql="CREATE TABLE old(filename char(64) not null,PRIMARY KEY(filename),uploadedby CHAR(255))";
if (mysqli_query($con,$sql))
  {
  echo "Table old created successfully<br>";
  }
else
  {
  echo "Error creating table: " . mysqli_error($con) . "<br>";
  }
?>