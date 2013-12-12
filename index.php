<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Grant High School Yearbook</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    </head>
    <body>
    <h1 id="title">Grant High School Yearbook</h1>
    <a href="problem.html"></a>
    <p>Enter the password:</p>
    <form action="verify.php" method="post">
        <table>
            <tr><td>Username: <td><input type="text" name="username">
            <tr><td>Password:<td><input type="password" name="password">
            <td><input type="submit" value="Login">
        </table>
    </form>
<?php session_start();
if (empty($_SESSION['invalid'])) { //If invalid has no value set it to false so it doesn't give errors
    $_SESSION['invalid'] = false;
}
if ($_SESSION['invalid'] == true) {
    echo "<p id=invalid>Invalid password!</p>"; //Display invalid password if the user entered an incorrect password
    $_SESSION['invalid'] = false; //Reset invalid
}
if(!empty($_SESSION['validPassword'])) { //If the password has been verified this session, redirect to the files page
    if($_SESSION['validPassword'] === true) {
       // echo '<meta http-equiv="refresh" content="0;URL=/verify.php" />';
    }
}
?>
        <a href="./register.php">Register</a>
        <p>If you find any bugs, report them to the website's <a href="https://github.com/waylon531/grantyearbook/issues">github</a></p>
    </body>
</html>
