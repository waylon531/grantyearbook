<?php 
$hash = "23a33778aadbd7cf9a529979b01dbff5"; //The password hash
//Checks the entered password against the password hash
if (password_verify($_POST["password"], $hash)) {
    $files = scandir('./files'); //Change directory to where the files will be saved
    sort($files); // this does the sorting
    foreach($files as $file){
        echo'<a href="./files'.$file.'">'.$file.'</a><br>'; //Change "../finalproject" to the directory where the files are saved
    }

} else {
    echo 'Invalid Password';
}
?>