<?php session_start();?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <?php include "metadata.html";?>
        <title>ThumpNet</title>
        <link rel="stylesheet" href="landing.css"/>
    </head>
    <body>
        <div>
            <a style="font-size:2em;font-weight:bold;display:block;color:var(--foreground-color);text-decoration:none;" href="/">ThumpNet</a>
            <?php
                if(isset($_SESSION["username"]))
                {
                    echo "<div>Logged in as: " . htmlspecialchars($_SESSION["username"]) . " (" . htmlspecialchars($_SESSION["id"]) . ")</div>";

                    echo "<form action=\"logout.php\">";
                    echo "    <input type=\"submit\" value=\"Logout\"/>";
                    echo "</form>";
                }
                else
                {
                    echo "<form action=\"login.php\">";
                    echo "    <input type=\"submit\" value=\"Login\"/>";
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

                    echo "<div>" . htmlspecialchars($row["name"]) . "</div>";

                    if(isset($row["description"]))
                        echo "<div>" . htmlspecialchars($row["description"]) . "</div>";
                    else
                        echo "<div>No description set</div>";

                    if(isset($row["difficulty"]))
                        echo "<div>D" . htmlspecialchars($row["difficulty"]) . "</div>";

                    if($row["has_thumb"] == "1")
                        echo "<img src=\"cdn/" . $row["cdn"] . ".png\"/>";

                    else
                        echo "<div>No difficulty</div>";
                }
            ?>
        </div>
    </body>
</html>