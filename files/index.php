<?php session_start();
if(empty($_SESSION["password"])) {
    echo '<a href="/index.php">Go home!</a>';
} else {
    echo '<a href="/verify.php">Go back!</a>';
}

?>