<!DOCTYPE html>
<html>
    <head>
        <?php
            session_start();
            if (!isset($_SESSION["id"]))
            {
                header("Location: /");
                die("Forbidden");
            }

            include "api/db.php";

            $reply = "";

            $isplayplus = 0;
            if(isset($_POST["playplus"])) $isplayplus = 1;


            $stmt = $mysqli->prepare("INSERT INTO `scores_awaiting` (`author`, `level`, `score`, `evidence`, `playplus`) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiisi", $_SESSION["id"], $_POST["level"], $_POST["score"], $_POST["evidence"], $isplayplus);
            if($stmt->execute())
            {
                $reply = "Score submitted";
            }
            else
            {
                $reply = "Score failed to submit";
            }

            header("Location: " . $_GET["url"] . "&status=" . urlencode($reply));
        ?>
    </head>
</html>
