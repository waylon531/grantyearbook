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
            <tr><td>Password:<td><input type="password" name="password">
            <tr><td>Verify password:<td><input type="password" name="password2">
            <tr><td>Account creation password:<td><input type="password" name="password3">
            <td><input type="submit" value="Register">
        </table>
    </form>
<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');
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
if ($_POST['password'] === $_POST['password2'] and md5($_POST['password3']) === "a6bf2e0ec667108627f1a499dae35671a6bf2e0ec667108627f1a499dae35671") {
    $hash = md5($_POST['password']);
    echo $_POST['username'];
    echo $hash;
    $useruser = $_POST['username'];
   if (!mysqli_query($con, "INSERT INTO `userpass`.`userpass` (`username`, `hash`) VALUES ('$useruser', '$hash')"))
      {
  die('Error: ' . mysqli_error($con));
  }
    echo "<p id='valid'>Registration complete!</p>";
} else  if ($_POST['password2'] != $_POST['password'] and !empty($_POST['password2'])){
    echo "<p id='invalid'>Passwords do not match</p>";
} else if (md5($_POST['password3'])!= "a6bf2e0ec667108627f1a499dae35671a6bf2e0ec667108627f1a499dae35671" and !empty($_POST['password3'])) {
    echo "<p id='invalid'>Incorrect account creation password</p>";
}
echo '<form name="input" action="/verify.php" method="post">
<input type="submit" value="Back">
</form>';
?>
    </body>
</html>