<?php session_start();?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <?php include "metadata.html";?>
        <link rel="stylesheet" href="layout.css"/>
        <meta name="robots" content="noindex"/>
        <?php
            if(!isset($_SESSION["id"]))
            {
                header("Location: /");
                die("Forbidden");
            }
            if($_SESSION["permission_level"] < 1)
            {
                header("Location: /");
                die("Forbidden");
            }

            include "api/db.php";
        ?>
    </head>
    <body>
        <?php include "header.php";?>
        <div>
            <?php
                $result = $mysqli->query("SELECT * FROM `scores_awaiting`");

                for ($row_no = 0; $row_no < $result->num_rows; $row_no++)
                {
                   

                    $result->data_seek($row_no);
                    $row = $result->fetch_assoc();

                    // Fetch username and level name/id
                    $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE `id` = ?");
                    $stmt->bind_param("i", $row["author"]);
                    $stmt->execute();
                    $stmt_result = $stmt->get_result();
                    $username = $stmt_result->fetch_assoc()["username"];

                    $stmt = $mysqli->prepare("SELECT * FROM `levels` WHERE `id` = ?");
                    $stmt->bind_param("i", $row["level"]);
                    $stmt->execute();
                    $stmt_result = $stmt->get_result();
                    $level_name = $stmt_result->fetch_assoc()["name"];

                    echo htmlspecialchars($username) . "<br/>";
                    echo htmlspecialchars($level_name) . "<br/>";
                    echo number_format($row["score"]) . "<br/>";
                    echo "<img src=\"" . htmlspecialchars($row["evidence"]) . "\"/><br/>";

                    echo "Playplus: " . $row["playplus"];

                    echo "<form action=\"score_approval.php?url=" . urlencode($_SERVER["REQUEST_URI"]) . "\" method=\"POST\">";
                    echo "<input type=\"submit\" value=\"Approve\"/>";
                    echo "<input type=\"hidden\" name=\"id\" value=\"" . $row["id"] . "\"/>";
                    echo "<input type=\"hidden\" name=\"status\" value=\"accept\"/>";
                    echo "</form>";

                    echo "<form action=\"score_approval.php?url=" . urlencode($_SERVER["REQUEST_URI"]) . "\" method=\"POST\">";
                    echo "<input type=\"submit\" value=\"Reject\"/>";
                    echo "<input type=\"hidden\" name=\"id\" value=\"" . $row["id"] . "\"/>";
                    echo "<input type=\"hidden\" name=\"status\" value=\"reject\"/>";
                    echo "</form>";
                }
            ?>
        </div>
    </body>
</html>