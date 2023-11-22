<?php session_start();// THIS FILE IS UNUSED?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <?php

        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $stmt = $mysqli->prepare("SELECT `password` FROM `users` WHERE `username` = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $password_check = $row["password"] . '<br/>';
        
        if ($password == $password_check)
        {
            echo "Welcome, " . $username;
            $_SESSION['username'] = $_POST["username"];
        }
        else echo "error";
        ?>
    </body>
</html>