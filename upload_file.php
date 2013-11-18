<?php
if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
  }
else
  {
  echo "Upload: " . $_FILES["file"]["name"] . "<br>";
  $file = $_FILES["file"]["name"];
  echo "Type: " . $_FILES["file"]["type"] . "<br>";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
  echo "Stored in: " . $_FILES["file"]["tmp_name"];
  $tmpFile = $_FILES["file"]["tmp_name"];
  echo "<br>";
    if (file_exists("files/" . $file) and $_POST["overwrite"]==="Yes")
      {
        echo "<p>Overwriting</p>";
        //checking if file exsists
        if(file_exists('files/' . $file)) unlink('files/' . $file);
        echo "Stored in: " . "files/" . $_FILES["file"]["name"];

        //Place it into your "uploads" folder mow using the move_uploaded_file() function
        move_uploaded_file($_FILES["file"]["tmp_name"], 'files/' . $file);
      } else if (file_exists("files/" . $file) and $_POST["overwrite"]==="No") {
        echo "<p>File not overwritten</p>";
    } else {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "files/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "files/" . $_FILES["file"]["name"];
      }
  }
echo "<br><a href='/index.html'>Home</a>";
?> 