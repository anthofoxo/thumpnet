<?php
// If upload works, direct to the level view page
// Otherwise reload the form
session_start();

if (!isset($_SESSION["id"])) exit; // You must be logged in to upload
//if (!isset($_FILES["content"]["name"])) {
//    echo "No file uploaded";
//    exit; // You must upload a file to create an entry
//}

function format_uuidv4()
{
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100 (Version 4 uuid)
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

$uuid = format_uuidv4(); // Generate a uuid for this upload

// Upload level content
if (isset($_FILES["content"]["name"])) {

    $target_file = "../cdn/" . $uuid . ".zip";
    $uploadOk = 1;
    
    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["content"]["size"] > 2048000) { // 2 Megabyte limit // May need to increase
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    $imageFileType = strtolower(pathinfo(basename($_FILES["content"]["name"]),PATHINFO_EXTENSION));
    
    // Allow certain file formats
    if($imageFileType != "zip") {
      echo "Sorry, only ZIP files are allowed.";
      $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["content"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["content"]["name"])). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
}

// Upload thumbnail
if (isset($_FILES["thumbnail"]["name"])) {

    $target_file = "../cdn/" . $uuid . ".png";
    $uploadOk = 1;
    
    $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["thumbnail"]["size"] > 2048000) { // 2 Megabyte limit // May need to increase
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    $imageFileType = strtolower(pathinfo(basename($_FILES["thumbnail"]["name"]),PATHINFO_EXTENSION));
    
    // Allow certain file formats
    if($imageFileType != "png") {
      echo "Sorry, only PNG files are allowed.";
      $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["thumbnail"]["name"])). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
}

// Make database connection
include "../api/db.php";

$one = 1;
$nullp = NULL;

$authors = "[" . $_SESSION["id"] . "]";

$stmt = $mysqli->prepare("INSERT INTO `levels` (`uploader`, `cdn`, `name`, `difficulty`, `authors`, `description`, `has_content`, `has_thumb`, `extra`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ississiis", $_SESSION["id"], $uuid, $_POST["level_name"], $_POST["difficulty"], $authors, $_POST["description"], $one, $one, $nullp);
if(!$stmt->execute())
{
    echo '<h1>Operation Failed</h1>';
    exit;
}

$stmt = $mysqli->prepare("SELECT `id` FROM `levels` WHERE `cdn` = ?");
$stmt->bind_param("s", $uuid);
if(!$stmt->execute())
{
    echo '<h1>Operation Failed</h1>';
    exit;
}

$result = $stmt->get_result();

if($result->num_rows != 1)
{
    echo "Invalid";
    exit;
}

$row = $result->fetch_assoc();

echo '<div hx-get="/view.php?level=' . $row["id"] . 'hx-target="#content" hx-trigger="load"></div>';
?>
