<?php
// If upload works, direct to the level view page
// Otherwise reload the form
session_start();

if (!isset($_SESSION["id"])) {
    echo '<div hx-get="/landing.html" hx-trigger"load" hx-target="#content"></div>';
    exit;
}

if (!isset($_FILES["content"]["name"])) {
    echo '<div hx-get="/upload_level.html" hx-trigger"load" hx-target="#content"></div>';
    exit;
}

if (empty($_POST["level_name"])) {
    echo '<div hx-get="/upload_level.html" hx-trigger"load" hx-target="#content"></div>';
    exit;
}

function format_uuidv4()
{
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

include "../api/db.php";

// Get unique uuids for content and thumbnail

$content_uuid = null;

if (isset($_FILES["content"]["name"])) {
    // Make sure the uploaded file passes the tests before trying anything more

    if ($_FILES["content"]["size"] > 128 * 1024 * 1024) { // 128 Mebibyte limit
        echo "Sorry, your file is too large.";
        exit;
    }

    if(strtolower(pathinfo(basename($_FILES["content"]["name"]),PATHINFO_EXTENSION)) != "zip") {
      echo "Sorry, only ZIP files are allowed.";
      exit;
    }

    do {
        $content_uuid = format_uuidv4();
    } while(file_exists("../cdn/" . $content_uuid));
}

$thumbnail_uuid = null;

if (isset($_FILES["thumbnail"]["name"])) {

    if ($_FILES["thumbnail"]["size"] > 16 * 1024 * 1024) { // 16 Mebibyte limit
        echo "Sorry, your file is too large.";
        exit;
    }

    if(strtolower(pathinfo(basename($_FILES["thumbnail"]["name"]),PATHINFO_EXTENSION)) != "png") {
      echo "Sorry, only PNG files are allowed.";
      exit;
    }

    $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
    if($check === false) {
      echo "File is not an image.";
      exit;
    }

    do {
        $thumbnail_uuid = format_uuidv4();
    } while(file_exists("../cdn/" . $thumbnail_uuid));
}

// Begin a transaction, this may have to be rolled back
$mysqli->begin_transaction();

$uploader = $_SESSION["id"];
$name = $_POST["level_name"];
$description = empty($_POST["description"]) ? null : $_POST["description"];
$authors = empty($_POST["authors"]) ? null : $_POST["authors"];
$difficulty = $_POST["difficulty"];
$bpm = $_POST["bpm"];
$sublevels = $_POST["sublevels"];
$song = empty($_POST["song"]) ? null : $_POST["song"];

$stmt = $mysqli->prepare("INSERT INTO `levels` (`uploader`, `name`, `content`, `thumbnail`, `description`, `authors`, `difficulty`, `bpm`, `sublevels`, `song`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");
$stmt->bind_param("isssssiiis", $uploader, $name, $content_uuid, $thumbnail_uuid, $description, $authors, $difficulty, $bpm, $sublevels, $song);
if(!$stmt->execute())
{
    echo '<h1>Operation Failed</h1>';
    $mysqli->rollback();
    exit;
}

// Database query worked, file checks passed, attempt to upload files

if(isset($content_uuid)){
    if (move_uploaded_file($_FILES["content"]["tmp_name"], "../cdn/" . $content_uuid)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["content"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
        $mysqli->rollback();
        exit;
    }
}

if(isset($thumbnail_uuid)){
    if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], "../cdn/" . $thumbnail_uuid)) {
        // success
        echo "The file ". htmlspecialchars( basename( $_FILES["content"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
        $mysqli->rollback();
        exit;
    }
}

$mysqli->commit();

// We succeeded, make a fetch and display the level
$stmt = $mysqli->prepare("SELECT `id` FROM `levels` WHERE `content` = ?");
$stmt->bind_param("s", $content_uuid);
if(!$stmt->execute()) exit;
$result = $stmt->get_result();
if($result->num_rows != 1) exit;
$row = $result->fetch_assoc();
echo '<div hx-get="/view.php?level=' . $row["id"] . 'hx-target="#content" hx-trigger="load"></div>';
?>
