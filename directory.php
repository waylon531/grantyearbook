<?php
session_start();
$dir = $_SESSION['uploadDirectory'] . $_POST['folder'];
mkdir($dir);
chmod($dir,0777); 
//echo $dir;
$index = $dir . "/index.php";
//echo $index;
copy("files/index.php",$index);
echo '<meta http-equiv="refresh" content="0;URL=' . $_SESSION['backlink'] . '" />';
?>