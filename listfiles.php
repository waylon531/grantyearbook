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
function content() {
echo '<a href="/redirect.php">Logout</a><br>';
    echo "<h2>Current Files</h2><p>Click on link to download.</p>";
    $files = scandir('./files/' . $_GET["folder"]); //Change directory to where the files will be saved
    sort($files); // this does the sorting
    echo "<table id='wtf'><tr><th>File Name</th><th>File Size</th><th>Date uploaded</th></tr>";
    foreach($files as $file){
        if ($file != "." and $file != ".." and $file != "index.php") { //Ignore the . and .. directories and index.php in the files directory when listing files
            echo "<tr>";
            $fileName = './files/' . $_GET["folder"] . '/' .$file;
                echo '<td><a href="' . $fileName . '"target="_blank" download>'.$file.'</a></td>';
                echo "<td>" . formatBytes(filesize($fileName)) . "</td>" ; //Creates a link to each file, displays filesize, and forces download
        $fileName = './files/' . $_GET["folder"] . '/' .$file;
            echo "<td>" . date ("F d Y H:i:s", filemtime($fileName)) . "</td>"; //Shows date modified
            echo "</tr>";
            }
        }
echo "</table>";
echo "<table>";
echo "<tr>";
echo "<td>";    
echo '<form name="input" action="/verify.php" method="post">
<input type="submit" value="Back">
</form>';
echo "<td>";
    echo '<form name="input" action="/listfiles.php/?folder=' . $_GET["folder"] . '" method="post">
<input type="submit" value="Click to refresh page"';
        echo ">
</form>";
echo "</table>";}
$version = PHP_VERSION_ID/100 - 500; //Get the version number and remove the 5 from the front of it
    if ($_SESSION['validPassword'] === true) { //Check password against plaintext. Uncomment line 34 and comment line 35 to enable password hash verification
        content();
    } else {
        $_SESSION['invalid'] = true; //If the password was incorrectly entered change invalid to true so that when you go back to the home page invalid password is displayed
        echo '<meta http-equiv="refresh" content="0;URL=/index.php" /> '; //If the password was incorrect return you to the login page
    }
?>
</html>