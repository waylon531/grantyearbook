<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="style.css">
<title>Grant High School Yearbook</title>

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
function content() {
    $version = PHP_VERSION_ID/100 - 500; //Get the version number and remove the 5 from the front of it
    $_SESSION['validPassword'] = true; //Save that the password was valid
    echo '<a href="redirect.php">Logout</a><br>';
    echo "<h2>Current Files</h2><p>Click on link to download.</p>";
    $files = scandir('./files'); //Change directory to where the files will be saved
    sort($files); // this does the sorting
    echo "<table><tr><th>File Name</th><th>File Size</th><th>Date uploaded</th></tr>";
    foreach($files as $file){
        if ($file != "." and $file != ".." and $file != "index.php") { //Ignore the . and .. directories and index.php in the files directory when listing files
            echo "<tr>";
            
            if (filesize('./files/' . $file) == 0) {
                echo '<td><a href="./listfiles.php/?folder=' . $file . '">'.$file.'</a></td>';
                echo "<td>FOLDER</td>";
            } else {
                echo '<td><a href="./files/'.$file.'"target="_blank" download>'.$file.'</a></td>';
                echo "<td>" . formatBytes(filesize('./files/' . $file)) ; //Creates a link to each file, displays filesize, and forces download
            }
            echo "<td>" . date ("F d Y H:i:s", filemtime('./files/' . $file)) . "</td>"; //Shows date modified
            echo "</tr>";
        }
    }
    echo "</table>";
    echo '<form name="input" action="/verify.php" method="post">
<input type="submit" value="Click to refresh page"';
        echo ">
</form>";
    echo "<p>To retrieve older versions of a file look through the folders old, older, and oldest for the file. If you want the current file to be that file, reupload it.</p>";
    echo '<script>var verify = true;</script>';
    $html = file_get_contents('./fileupload.php');
    echo $html;
    echo '<script>var verify = false;</script>';
    echo "<p>If you find any bugs, report them to the website's <a href='https://github.com/waylon531/grantyearbook/issues'>github</a></p>";
    echo 'This server is running php version 5.' . $version;}
//Checks the entered password against the password hash
//Get the version number and remove the 5 from th front of it
    if ("23a33778aadbd7cf9a529979b01dbff5" == md5($_SESSION['password'])) { //Check password using the md5 function.
        content();
    
    } else {
        $_SESSION['invalid'] = true; //If the password was incorrectly entered change invalid to true so that when you go back to the home page invalid password is displayed
        echo '<meta http-equiv="refresh" content="0;URL=index.php" /> '; //If the password was incorrect return you to the login page
    }
?>
