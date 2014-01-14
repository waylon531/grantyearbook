<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" type="text/css" href="/style.css">
    <link rel="stylesheet" type="text/css" href="/style2.css">
<title>Cloud Storage</title>
</head>
<?php session_start();
date_default_timezone_set('America/Los_Angeles');
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
    if (strpos($_GET['folder'],"../") !== FALSE) {die;}
    //echo $_SESSION['uploadDirectory']; //Debugging
    $html = file_get_contents('fileupload.php'); //File uploader
    echo $html;
    echo '<script>var verify = false;</script>';
    echo "<h2>Create Folder:</h2>";
    echo '<form action="/directory.php" method="post">
        <table>
            <tr><td>Folder Name: <td><input type="text" name="folder">
            <td><input type="submit" value="Create">
        </table>
    </form>';
    $_SESSION['backlink'] ='/listfiles.php/?folder=' . $_GET['folder'];
    /*if (strpos($_GET['folder'], "/") === FALSE) {
        $string = $_GET['folder'];
    } else {
        $string = strstr($_GET['folder'], '/');
        $string = substr($string, 1);
        $_GLOBALS['string'] = $string;
    }*/
    $string = "/" . $_GET['folder'];
    echo "<h2>Current Files in " . $string . "</h2><p>Click on link to download.</p>";
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
        $con=mysqli_connect("localhost","user","password","files");
                $rest = $_GET['folder'];
        $rest = substr($_SESSION['uploadDirectory'], 0, -1);
        $rest = str_replace("/",'\\',$rest);
        $rest = mysqli_real_escape_string($con,$rest);
                $result = mysqli_query($con,'SELECT * FROM `'.$rest.'` WHERE filename="'.$file.'"');
                if (!$result) {
                    mysqli_error($con);
                }
                //echo "<br>".$rest ."<br>". $file; //Debugging
                while($row = mysqli_fetch_array($result))
                {
                    $GLOBALS['uploader']=$row['uploadedby'];
                }
                echo "<td>".$GLOBALS['uploader']."</td>"; //Where uploaded by goes
            }
            echo "<td>" . date ("F d Y H:i:s", filemtime('./files/' . $_GET["folder"] . '/' . $file)) . "</td>"; //Shows date modified
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