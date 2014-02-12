<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="style2.css">
<title>Cloud Storage</title>

</head>
<?php session_start();
date_default_timezone_set('America/Los_Angeles');
// Create connection
$con=mysqli_connect("localhost","user","password","userpass");

// Check connection
if (empty($_POST['username'])) {
    $_POST['username'] = $_SESSION['username'];
}
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$result = mysqli_query($con,'SELECT * FROM userpass
WHERE username="' .$_POST['username']. '"');
$_SESSION['username'] = $_POST['username']; //Saves username to session
while($row = mysqli_fetch_array($result))
  {
    $GLOBALS['hash']=$row['hash'];
    $_SESSION['realname']=$row['realname'];
  }
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
    echo '<script>var verify = true;</script>';
    $_SESSION['uploadDirectory'] = 'files/';
    //echo $_SESSION['uploadDirectory']; //Debugging
    $html = file_get_contents('fileupload.php'); //Creates the uploader
    echo $html;
    echo '<script>var verify = false;</script>';
    echo '<div id="foldercreation">'; 
    echo "<h2>Create Folder:</h2>";
    echo '<form action="directory.php" method="post">
        <table>
            <tr><td>Folder Name: <td><input type="text" name="folder">
            <td><input type="submit" value="Create">
        </table>
    </form>';
    echo '</div>';
    $_SESSION['backlink'] = "verify.php";
    echo "<h2>Current Files</h2><p>Preview does not work for all filetypes, if you are trying to preview an unsupported file type it will try to download instead</p>";
    $files = scandir('files'); //Change directory to where the files will be saved
    sort($files); // this does the sorting
    echo '<table><tr><th>File Name</th><th /><th /><th /><th>File Size</th><th>Uploaded By:</th><th>Date Uploaded:</th></tr>';
    foreach($files as $file){
        if ($file != "." and $file != ".." and $file != "index.php") { //Ignore the . and .. directories and index.php in the files directory when listing files
            echo "<tr>";
            
            if (filetype('./files/' . $file) == "dir") {
                echo '<td>'.$file.'</td>';
                echo '<td><a id="folder" href="./listfiles.php?folder=' . $file . '">Open</a></td>';
                echo '<td></td>';
                echo "<td />";
                echo "<td>FOLDER</td>";
                echo "<td></td>";
                
            } else {
                echo '<td>'.$file.'</td>';
                echo '<td><a href="files/'.$file.'"target="_blank" download>Download</a></td>';
                echo '<td><a href="files/'.$file.'"target="_blank" >Preview</a></td>';
                echo '<td><a id="folder" href="./action.php?file=' . $file . '&action=delete">Delete</a></td>';
                echo "<td>" . formatBytes(filesize('./files/' . $file)) ; //Creates a link to each file, displays filesize, and forces download
        $con=mysqli_connect("localhost","user","password","files");
                $rest = "files\\";
                $rest = mysqli_real_escape_string($con,$rest);
                $result = mysqli_query($con,'SELECT * FROM `'.$rest.'` WHERE filename="' . $file . '"');
                if (!$result) {
                    die(mysqli_error($con));
                }
                //echo "<br>".$rest ."<br>". $file; //Debuggging
while($row = mysqli_fetch_array($result))
  {
    $GLOBALS['uploader']=$row['uploadedby'];
  }
                echo "<td>" . $GLOBALS['uploader'] . "</td>"; 
            }
            echo "<td>" . date ("F d Y H:i:s", filemtime('./files/' . $file)) . "</td>"; //Shows date modified
            echo "</tr>";
        }
    }
    echo "</table>";
    echo "<p>If you find any bugs, report them to the website's <a href='https://github.com/waylon531/grantyearbook/issues'>github</a></p>";
    //echo 'This server is running php version 5.' . $version;
}
    //echo sys_get_temp_dir();
//Checks the entered password against the password hash
//Get the version number and remove the 5 from th front of it
    if (password_verify($_SESSION['password'] , $GLOBALS['hash'])) { //Check password using the md5 function.
        content();
    
    } else {
        $_SESSION['invalid'] = true; //If the password was incorrectly entered change invalid to true so that when you go back to the home page invalid password is displayed
        echo '<meta http-equiv="refresh" content="0;URL=index.php" /> '; //If the password was incorrect return you to the login page
    }
?>
