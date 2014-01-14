<?php session_start();
function mySQLGet() {
   $result = mysqli_query($con,$GLOBALS['sql']);
        while($row = mysqli_fetch_array($result))
  { 
        $GLOBALS['uploadedBy'] = $row['uploadedby'];
        $GLOBALS['nameFile'] = $row['filename'];
  } 
}
/**
* upload.php
*
* Copyright 2013, Moxiecode Systems AB
* Released under GPL License.
*
* License: http://www.plupload.com/license
* Contributing: http://www.plupload.com/contributing
*/

#!! IMPORTANT:
#!! this file is just an example, it doesn't incorporate any security checks and
#!! is not recommended to be used in production environment as it is. Be sure to
#!! revise it and customize to your needs.


// Make sure file is not cached (as it happens for example on iOS devices)
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

/*
// Support CORS
header("Access-Control-Allow-Origin: *");
// other CORS headers if any...
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        exit; // finish preflight CORS requests here
}
*/

// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Settings
$targetDir = /*ini_get("upload_tmp_dir")*/sys_get_temp_dir() . DIRECTORY_SEPARATOR . "plupload";
//$targetDir = '/files/';
$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds


// Create target dir
if (!file_exists($targetDir)) {
        @mkdir($targetDir);
}

// Get a file name
if (isset($_REQUEST["name"])) {
        $fileName = $_REQUEST["name"];
} elseif (!empty($_FILES)) {
        $fileName = $_FILES["file"]["name"];
} else {
        $fileName = uniqid("file_");
    //$fileName = $_FILES["file"]["name"];
}

$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


// Remove old temp files        
if ($cleanupTargetDir) {
        if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
        }

        while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}.part") {
                        continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                        @unlink($tmpfilePath);
                }
        }
        closedir($dir);
}        


// Open temp file
if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

if (!empty($_FILES)) {
        if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        }

        // Read binary input stream and append it to temp file
        if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
        }
} else {        
        if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
        }
}

while ($buff = fread($in, 4096)) {
        fwrite($out, $buff);
}

@fclose($out);
@fclose($in);

// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1) {
        // Strip the temp .part suffix off
        rename("{$filePath}.part", $targetDir . DIRECTORY_SEPARATOR . $fileName);
    $file = $fileName;
  //echo "Type: " . $_FILES["file"]["type"] . "<br>";
  //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
  //echo "Stored in: " . $_FILES["file"]["tmp_name"];
  $tmpFile = $filePath;
 // echo "<br>";
    $con=mysqli_connect("localhost","user","password","files");
    $uploadDir = $_SESSION['uploadDirectory'] . $file;
    if ($_SESSION['uploadDirectory'] != "files/") {
        $rest = substr($_SESSION['uploadDirectory'], 0, -1);
        $rest = str_replace("/",'\\',$rest);
    } else {
        $rest = 'files\\';
    }
    $rest = mysqli_real_escape_string($con,$rest);
    $username = $_SESSION['username'];
    if (file_exists($uploadDir)) //Check if file exists
      {
        //echo "<p>Overwriting</p>";
        //checking if file exsists
        unlink($uploadDir);
        //Place the newest file into your "uploads" folder mow using the move_uploaded_file() function
        rename($tmpFile, $uploadDir);
    } else {
        rename($tmpFile, $uploadDir);
      //echo "Stored in: " . "files/" . $_FILES["file"]["name"];
    }
    $sql=mysqli_query($con,"INSERT INTO `files`.`$rest` (`filename`, `uploadedby`) VALUES ('$file', '$username')");
}

// Return Success JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');