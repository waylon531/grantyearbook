<?php 
$hash = "23a33778aadbd7cf9a529979b01dbff5"; //The password hash
//Checks the entered password against the password hash
//if (password_verify($_POST["password"], $hash)) {
if ($_POST["password"] == "password") { //Check password against plaintext
    $files = scandir('./files'); //Change directory to where the files will be saved
    sort($files); // this does the sorting
    foreach($files as $file){
        echo '<a href="./files/'.$file.'">'.$file.'</a><br>';
    }
    echo "<h3>File Upload</h3><br>";
    echo '<form action="upload_file.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file">
<p>Overwrite if it exists?</p>
<input type="radio" name="overwrite" value="Yes">Yes<br>
<input type="radio" name="overwrite" value="No">No<br>
<input type="submit" name="submit" value="Submit">
</form>';

} else {
    echo 'Invalid Password';
}
echo "<br><a href='/index.html'>Home</a>";
?>