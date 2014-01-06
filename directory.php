<?php
session_start();
mkdir($_SESSION['uploadDirectory'] . $_POST['folder']);
echo '<meta http-equiv="refresh" content="0;URL=' . $_SESSION['backlink'] . '" />'
?>