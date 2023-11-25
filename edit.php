<?php session_start();?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <?php include "metadata.html";?>
        <title>ThumpNet</title>
        <link rel="preload" href="default_thumb.jpg" as="image"/>
        <link rel="stylesheet" href="landing.css"/>
    </head>
    <body>
        <div>
            <span style="font-size: 2em;font-weight: bold;">ThumpNet</span>
            <?php
                if(isset($_SESSION["username"]))
                {
                    echo "<div>Logged in as: " . htmlspecialchars($_SESSION["username"]) . " (" . htmlspecialchars($_SESSION["id"]) . ")</div>";

                    echo "<form action=\"logout.php\">";
                    echo "  <input type=\"submit\" value=\"Logout\"></input>";
                    echo "</form>";
                }
                else
                {
                    echo "<form action=\"login.php\">";
                    echo "  <input type=\"submit\" value=\"Login\"></input>";
                    echo "</form>";
                }
            ?>
        </div>
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

                    if($row["uploader"] == $_SESSION["id"])
                    {
                        echo "You own this level :)<br>";
                    }

                    echo $row["name"];
                }
            ?>
        </div>
    </body>
</html>