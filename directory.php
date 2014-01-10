<?php
session_start();
$con=mysqli_connect("localhost","user","password","files");
$dir = $_SESSION['uploadDirectory'] . $_POST['folder'];
mkdir($dir);
chmod($dir,0777); 
//echo $dir;
$index = $dir . "/index.php";
//echo $index;
copy("files/index.php",$index);
$rest = str_replace("/",'\\',$dir);
$rest = mysqli_real_escape_string($con,$rest);
$sql="CREATE TABLE `$rest` (filename char(64) not null,PRIMARY KEY(filename),uploadedby CHAR(255))";
if (mysqli_query($con,$sql))
  {
  echo "Table" .$dir. "created successfully<br>";
  }
else
  {
  echo "Error creating table: " . mysqli_error($con) . "<br>";
  }
echo '<meta http-equiv="refresh" content="0;URL=' . $_SESSION['backlink'] . '" />';
?>