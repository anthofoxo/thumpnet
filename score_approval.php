<!DOCTYPE html>
<html>
    <head>
        <?php
            session_start();
            if (!isset($_SESSION["id"]))
            {
                header("Location: " . $_GET["url"]);
                die("Forbidden");
            }
            if ($_SESSION["permission_level"] < 1)
            {
                header("Location: " . $_GET["url"]);
                die("Forbidden");
            }

            include "api/db.php";

            if ($_POST["status"] == "accept")
            {
                $stmt = $mysqli->prepare("SELECT * FROM `scores_awaiting` WHERE `id` = ?");
                $stmt->bind_param("i", $_POST["id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                $insert = $mysqli->prepare("INSERT INTO `scores` (`user`, `level`, `score`, `playplus`, `timestamp`, `approved_by`) VALUES (?, ?, ?, ?, ?, ?)");
                $insert->bind_param("iiiisi", $row["author"], $row["level"], $row["score"], $row["playplus"], $row["timestamp"], $_SESSION["id"]);
                $insert->execute();

                $stmt = $mysqli->prepare("DELETE FROM `scores_awaiting` WHERE `id` = ?");
                $stmt->bind_param("i", $_POST["id"]);
                $stmt->execute();

                header("Location: " . $_GET["url"]);
            }

            if ($_POST["status"] == "reject")
            {
                echo "Rejected";

                $stmt = $mysqli->prepare("DELETE FROM `scores_awaiting` WHERE `id` = ?");
                $stmt->bind_param("i", $_POST["id"]);
                $stmt->execute();
                header("Location: " . $_GET["url"]);
            }

           // header("Location: " . $_GET["url"]);
        ?>
    </head>
</html>
