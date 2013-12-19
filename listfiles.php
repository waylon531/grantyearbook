<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="/style.css">
<title>Grant High School Yearbook</title>
</head>
<?php session_start();
function formatBytes($size, $precision = 2) //function to change file size suffix based on size
{
    $base = log($size) / log(1024);
    $suffixes = array('B', 'k', 'M', 'G', 'T');   

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}
function find_to_last_char($str, $char) {
  $reversed_string = strrev($str);
  $char_pos = strpos($reversed_string, $char);
  if ($char_pos === false) return $str; // character not present
  $trim = substr($reversed_string, $char_pos);
  return strrev($trim);
}
function content() {
echo '<a href="/redirect.php">Logout</a><br>';
    echo '<script>var verify = true;</script>';
    $_SESSION['uploadDirectory'] = 'files/' . $_GET["folder"] . '/';
    //echo $_SESSION['uploadDirectory']; //Debugging
    $html = file_get_contents('fileupload.php'); //File uploader
    echo $html;
    echo '<script>var verify = false;</script>';
    echo "<h2>Current Files</h2><p>Click on link to download.</p>";
    $files = scandir('./files/' . $_GET["folder"]); //Change directory to where the files will be saved
    sort($files); // this does the sorting
    echo "<table id='wtf'><tr><th>File Name</th><th /><th /><th>File Size</th><th>Uploaded By:</th><th>Date uploaded</th></tr>";
    foreach($files as $file){
        if ($file != "." and $file != ".." and $file != "index.php") { //Ignore the . and .. directories and index.php in the files directory when listing files
            echo "<tr>";
            
            if (filetype('./files/' . $_GET["folder"] . '/' . $file) == "dir") {
                echo '<td>'.$file.'</td>';
                echo '<td><a id="folder" href="/listfiles.php/?folder=' . $_GET["folder"] . '/' . $file . '">Open</a></td>';
                echo '<td></td>';
                echo "<td>FOLDER</td>";
                echo "<td></td>";
            } else {
                echo '<td>'.$file.'</td>';
                echo '<td><a href="/files/'. $_GET["folder"] . '/' .$file.'"target="_blank" download>Download</a></td>';
                echo '<td><a href="/files/'. $_GET["folder"] . '/' .$file.'"target="_blank" >Preview</a></td>';
                echo "<td>" . formatBytes(filesize('./files/' . $_GET["folder"] . '/' . $file)) ; //Creates a link to each file, displays filesize, and forces download
                //echo "<td>" . $GLOBALS['uploader'] . "</td>"; 
                echo "<td />";
            }
            echo "<td>" . date ("F d Y H:i:s", filemtime('./files/' . $file)) . "</td>"; //Shows date modified
            echo "</tr>";
        }
        }
echo "</table>";
echo "<table>";
echo "<tr>";
echo "<td>";    
   // echo $_GET["folder"] . "<br>"; //Debugging
$folder = find_to_last_char($_GET["folder"], '/');
    $folder = substr($folder, 0, -1); //Remove the / at the end of the string
    //echo $folder; //Debugging
//echo '<a href="/listfiles.php/?folder=' . $folder . '">BACK
//</a>';
    
    if (strpos($_GET["folder"], '/') === false) {
        echo '<form name="input" action="/verify.php" method="post">
<input type="submit" value="Back">';
    } else {
echo '<form name="input" action="/listfiles.php/?folder=' . $folder . '" method="post">
<input type="submit" value="Back">';
        }
echo "</form>";
    echo "<td>";
    echo '<form name="input" action="/listfiles.php/?folder=' . $_GET["folder"] . '" method="post">
<input type="submit" value="Click to refresh page"';
        echo ">
</form>";
echo "</table>";
}
$version = PHP_VERSION_ID/100 - 500; //Get the version number and remove the 5 from the front of it
    if ($_SESSION['validPassword'] === true) { //Check password against plaintext. Uncomment line 34 and comment line 35 to enable password hash verification
        content();
    } else {
        $_SESSION['invalid'] = true; //If the password was incorrectly entered change invalid to true so that when you go back to the home page invalid password is displayed
        echo '<meta http-equiv="refresh" content="0;URL=/index.php" /> '; //If the password was incorrect return you to the login page
    }
?>
</html>