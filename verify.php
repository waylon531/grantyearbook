<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="style.css">
<title>Grant High School Yearbook</title>

<!-- production -->
<script type="text/javascript" src="/plupload-2.0.0/js/plupload.full.min.js"></script>
<script type="text/javascript" src="./uploadsettings.js"></script>


<!-- debug
<script type="text/javascript" src="../js/moxie.js"></script>
<script type="text/javascript" src="../js/plupload.dev.js"></script>
-->

</head>
<?php session_start();
if(!empty($_POST["password"])){ //Set the password variable in the session to the password entered
    $_SESSION['password'] = $_POST["password"];
} else if(empty($_SESSION["password"])) { 
    $_SESSION['password'] = ""; //If password was not entered initialize it so there are no errors
}
function formatBytes($size, $precision = 2) //function to change file size suffix based on size
{
    $base = log($size) / log(1024);
    $suffixes = array('B', 'k', 'M', 'G', 'T');   

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}
$hash = "23a33778aadbd7cf9a529979b01dbff5"; //The password hash
//Checks the entered password against the password hash
//if (password_verify($_SESSION["password"], $hash)) {
if ($_SESSION['password'] == "password") { //Check password against plaintext. Uncomment line 9 and comment line 10 to enable password hash verification
    echo '<a href="redirect.php">Logout</a><br>';
    echo "<h2>Current Files</h2><p>Click on link to download.</p>";
    $files = scandir('./files'); //Change directory to where the files will be saved
    sort($files); // this does the sorting
    echo "<table><tr><th>File Name</th><th>File Size</th><th>Date uploaded</th></tr>";
    foreach($files as $file){
        if ($file != "." and $file != ".." and $file != "index.php") { //Ignore the . and .. directories and index.php in the files directory when listing files
            echo "<tr>";
            echo '<td><a href="./files/'.$file.'"target="_blank" download>'.$file.'</a>';
            echo "<td>" . formatBytes(filesize('./files/' . $file)) ; //Creates a link to each file, displays filesize, and forces download
            echo "<td>" . date ("F d Y H:i:s", filemtime('./files/' . $file)); //Shows date modified
            echo "</tr>";
        }
    }
    echo "</table>";
    /*echo "<h3>File Upload</h3><br>"; //Create a form for file upload
    echo '<form action="upload_file.php" method="post" 
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file">
<p>Overwrite if it exists?</p>
<input type="radio" name="overwrite" value="Yes">Yes<br>
<input type="radio" name="overwrite" value="No" checked>No<br>
<input type="submit" name="submit" value="Submit">
</form>'; Old upload form*/
    echo '<script>var verify = true;</script>';
    $html = file_get_contents('./fileupload.php');
    echo $html;
    echo '<script>var verify = false;</script>';
    if (!isset($_SESSION['overwritten'])) {
        $_SESSION['overwritten'] = "";
    }
    if ($_SESSION['overwritten'] === false) {
        echo "<p id=invalid>File not overwritten</p>";
    } else if ($_SESSION['overwritten'] === true) {
        echo "<p id=valid>File successfully overwritten</p>";
    }
    $_SESSION['overwritten'] = "";
} else {
    $_SESSION['invalid'] = true; //If the password was incorrectly entered change invalid to true so that when you go back to the home page invalid password is displayed
    echo '<meta http-equiv="refresh" content="0;URL=index.php" /> '; //If the password was incorrect return you to the login page
}
?>