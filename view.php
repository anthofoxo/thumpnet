<?php session_start();?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <?php include "metadata.html";?>
        <link rel="stylesheet" href="layout.css"/>
        <link rel="stylesheet" href="landing.css"/>
    </head>
    <body>
        <?php include "header.php"?>
        <div>
            <?php
                if(isset($_GET["level"]))
                {
                    include "api/db.php";

                    $stmt = $mysqli->prepare("SELECT * FROM `levels` WHERE `id` = ?");
                    $stmt->bind_param("i", $_GET["level"]);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if($result->num_rows != 1)
                    {
                        echo "Invalid level";
                        exit;
                    }

                    $row = $result->fetch_assoc();

                    echo "<div>" . htmlspecialchars($row["name"]) . "</div>";

                    if(isset($row["description"]))
                        echo "<div>" . htmlspecialchars($row["description"]) . "</div>";
                    else
                        echo "<div>No description set</div>";

                    if(isset($row["difficulty"]))
                        echo "<div>D" . htmlspecialchars($row["difficulty"]) . "</div>";

                    if($row["has_thumb"] == "1")
                        echo "<img src=\"cdn/" . $row["cdn"] . ".png\"/><br/>";

                    else
                        echo "<div>No difficulty</div>";

                 

                    $stmt = $mysqli->prepare("SELECT * from `scores` WHERE `level` = ? ORDER BY `score` DESC");
                    $stmt->bind_param("i", $_GET["level"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result->num_rows == 0)
                    {
                        echo "No scores submitted";
                        exit;
                    }
                    else
                    {
                        echo "Top scores<br/>";
                        for($i = 0; $i < $result->num_rows; $i++)
                        {
                            $row = $result->fetch_assoc();

                            $user_lookup = $mysqli->prepare("SELECT `username` from `users` WHERE `id` = ?");
                            $user_lookup->bind_param("i", $row["user"]);
                            $user_lookup->execute();
                            $user_lookup_result = $user_lookup->get_result();
                            $user_lookup_row = $user_lookup_result->fetch_assoc();

                            echo htmlspecialchars($row["score"]) . " achieved by: " . htmlspecialchars($user_lookup_row["username"]) . "<br/>";
                            
                        }
                    }
                }
            ?>
        </div>
    </body>
</html>