<?php
session_start();
echo '<div hx-get="/detail/subtitle.php" hx-trigger="load"></div>';

if(isset($_SESSION["username"])) exit;

if(isset($_POST["username"]))
{
    include "api/db.php";
    $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE `username` = ?");
    $stmt->bind_param("s", $_POST["username"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows != 1) exit;
    $row = $result->fetch_assoc();
    
    if(password_verify($config["security"]["secretkey"] . $_POST["password"], $row["password"]))
    {
        $_SESSION["id"] = $row["id"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["permission_level"] = $row["permission_level"];
    }
}
?>