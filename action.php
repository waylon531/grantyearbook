<?php
session_start();
if ($_GET['action'] == "delete") {
    $con=mysqli_connect("localhost","user","password","files");
    $file=$_GET['file'];
    $dir="files/" . $_GET['directory'];
    unlink('./'.$dir.'/'.$_GET['file']); //Delete the file
    if ($dir != "files/") {
        //$rest = substr(directory, 0, -1);
        $dir = str_replace("/",'\\',$dir);
    } else {
        $dir = 'files\\';
    }
    $dir = mysqli_real_escape_string($con, $dir);
    $file = mysqli_real_escape_string($con, $file);
    //echo $dir;
    //echo $file;
    mysqli_query($con,"DELETE FROM `$dir` WHERE `filename`='$file'");
    echo mysqli_error($con);
}
echo '<meta http-equiv="refresh" content="0;URL=' . $_SESSION['backlink'] . '" />'; //Redirect user after page has finished work
?>