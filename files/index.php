<?php session_start();
if(empty($_SESSION["password"])) {
    echo '<meta http-equiv="refresh" content="0;URL=/index.php" />';
} else {
    echo '<meta http-equiv="refresh" content="0;URL=/verify.php" />';
}

?>