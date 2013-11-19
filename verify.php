<?php session_start();
if(!empty($_POST["password"])){ 
    $_SESSION['password'] = $_POST["password"];
} else if(empty($_SESSION["password"])) { 
    $_SESSION['password'] = "";
}
$hash = "23a33778aadbd7cf9a529979b01dbff5"; //The password hash
//Checks the entered password against the password hash
//if (password_verify($_SESSION["password"], $hash)) {
if ($_SESSION['password'] == "password") { //Check password against plaintext. Uncomment line 9 and comment line 10 to enable password hash verification
    
    echo '<a href="redirect.php">Logout</a><br>';
    echo "<h2>Current Files</h2><p>Click on link to download. If file opens in browser, you can right click and choose save as to save the file.</p>";
    $files = scandir('./files'); //Change directory to where the files will be saved
    sort($files); // this does the sorting
    foreach($files as $file){
        if ($file != ".") {
            if ($file != "..") {
            echo '<a href="./files/'.$file.'"target="_blank">'.$file.'</a><br>';
            }
        }
    }
    echo "<h3>File Upload</h3><br>";
    echo '<form action="upload_file.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file">
<p>Overwrite if it exists?</p>
<input type="radio" name="overwrite" value="Yes">Yes<br>
<input type="radio" name="overwrite" value="No" checked>No<br>
<input type="submit" name="submit" value="Submit">
</form>';

} else {
    echo 'Invalid Password';
    echo "<br><a href='/index.html'>Back</a>";
}
?>