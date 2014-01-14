<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Grant High School Yearbook</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    </head>
    <body>
    <form action="register.php" method="post">
        <table>
            <tr><td>Username: <td><input type="text" name="username">
            <tr><td>Real Name: <td><input type="text" name="name">
            <tr><td>Password:<td><input type="password" name="password">
            <tr><td>Verify password:<td><input type="password" name="password2">
            <tr><td>Account creation password:<td><input type="password" name="password3">
            <td><input type="submit" value="Register">
        </table>
    </form>
<?php
session_start();
//echo $_SESSION['uploadDirectory'];
$_SESSION['invalid'] = false;
$con=mysqli_connect("localhost","user","password","userpass");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
if (empty($_POST['password'])) {
    $_POST['password'] = 42;
}
if (empty($_POST['password2'])) {
    $_POST['password2'] = "";
}
if (empty($_POST['password3'])) {
    $_POST['password3'] = "";
}
$hash = "5f4dcc3b5aa765d61d8327deb882cf99";
$passhash = md5($_POST['password3']);
/*echo md5($_POST['password3']) . "<br>"; //For debugging
echo $hash . "<br>";
echo $passhash . "<br>";*/
if ($_POST['password'] === $_POST['password2'] and $passhash  == $hash) {
    //$hash = md5($_POST['password']); MD5, not used
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    /*echo $_POST['username']; //Debugging
    echo $hash;*/
    $name = $_POST['name'];
    $useruser = $_POST['username'];
   if (!mysqli_query($con, "INSERT INTO `userpass`.`userpass` (`username`, `hash`, `realname`) VALUES ('$useruser', '$hash', '$name')"))
      {
    //die('Error: ' . mysqli_error($con));
      echo "<p id='invalid'>User already exists</p>";
  } else {
    echo "<p id='valid'>Registration complete!</p>";}
} else  if ($_POST['password2'] != $_POST['password'] and !empty($_POST['password2'])){
    echo "<p id='invalid'>Passwords do not match</p>";
} else if (md5($_POST['password3'])!= $hash and !empty($_POST['password3'])) {
    echo "<p id='invalid'>Incorrect account creation password</p>";
}
?>
<form name="input" action="/index.php" method="post">
<input type="submit" value="Back">
</form>
    </body>
</html>