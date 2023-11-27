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
                echo "<meta http-equiv=\"refresh\" content=\"0;url=/\"/>";
                exit;
            }
            if($_SESSION["permission_level"] <= 0)
            {
                echo "<meta http-equiv=\"refresh\" content=\"0;url=/\"/>";
                exit;
            }

            include "api/db.php";

            if(isset($_POST["what"]))
            {
                if("set_password" == $_POST["what"])
                {
                    $hashed = password_hash($config["security"]["secretkey"] . $_POST["password"], PASSWORD_BCRYPT);
    
                    $stmt = $mysqli->prepare("UPDATE `users` SET `password` = ? WHERE `id` = ?");
                    $stmt->bind_param("si", $hashed, $_POST["id"]);
                    if(!$stmt->execute())
                    {
                        echo "<h1>Operation Failed</h1>";
                        echo "<meta http-equiv=\"refresh\" content=\"5\"/>";
                        exit;
                    }
                    else
                    {
                        echo "<meta http-equiv=\"refresh\" content=\"0\"/>";
                        exit;
                    }
                }

                if("add_user" == $_POST["what"])
                {
                    
    
                    $stmt = $mysqli->prepare("INSERT INTO `users` (`username`, `permission_level`, `password`) VALUES (?, '0', 'unset')");
                    $stmt->bind_param("s", $_POST["username"]);
                    if(!$stmt->execute())
                    {
                        echo "<h1>Operation Failed</h1>";
                        echo "<meta http-equiv=\"refresh\" content=\"5\"/>";
                        exit;
                    }
                    else
                    {
                        echo "<meta http-equiv=\"refresh\" content=\"0\"/>";
                        exit;
                    }


                }

                if("add_score" == $_POST["what"])
                {
                    
                    $playplus = isset($_POST["playplus"]) ? "1" : "0";
    
                    $stmt = $mysqli->prepare("INSERT INTO `scores` (`user`, `level`, `score`, `playplus`) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("iiii", $_POST["user"], $_POST["level"], $_POST["score"], $playplus);
                    if(!$stmt->execute())
                    {
                        echo "<h1>Operation Failed</h1>";
                        echo "<meta http-equiv=\"refresh\" content=\"5\"/>";
                        exit;
                    }
                    else
                    {
                        echo "<meta http-equiv=\"refresh\" content=\"0\"/>";
                        exit;
                    }
                }
            }
            
        ?>
    </head>
    <body>
        <?php include "header.php";?>
        <div>
            <?php
                // !!! NO NOT ATTEMPT TO EXECUTE ANY OF THIS CODE OF YOU ARENT AN ADMIN AND LOGGED IN !!!
                if(!isset($_SESSION["id"]))
                {
                    echo "<meta http-equiv=\"refresh\" content=\"0;url=/\"/>";
                    exit;
                }
                if($_SESSION["permission_level"] <= 0)
                {
                    echo "<meta http-equiv=\"refresh\" content=\"0;url=/\"/>";
                    exit;
                }

                // Databse connection
                

                $result = $mysqli->query("SELECT * FROM `users`");

                $userid_lookup = array();

                echo "<h3>Current users</h3>";
                for ($row_no = 0; $row_no < $result->num_rows; $row_no++)
                {
                    $result->data_seek($row_no);
                    $row = $result->fetch_assoc();

                    echo $row["username"] . " (" . $row["permission_level"] . ")";

                    echo "<form action=\"#\" method=\"POST\">";
                    echo "<input type=\"password\" name=\"password\" placeholder=\"Set Password\"/>";
                    echo "<input type=\"hidden\" name=\"what\" value=\"set_password\"/>";
                    echo "<input type=\"hidden\" name=\"id\" value=\"" . $row["id"] . "\"/>";
                    echo "</form>";
                    
                    echo "<br/>";

                    $userid_lookup[$row["id"]] = $row["username"];
                }

                echo "<h3>Add user</h3>";
                echo "<form action=\"#\" method=\"POST\">";
                echo "<input type=\"text\" name=\"username\" placeholder=\"Add User\"/>";
                echo "<input type=\"hidden\" name=\"what\" value=\"add_user\"/>";
                echo "</form>";

                $result = $mysqli->query("SELECT * FROM `levels`");

                echo "<h3>Current levels</h3>";
                for ($row_no = 0; $row_no < $result->num_rows; $row_no++)
                {
                    $result->data_seek($row_no);
                    $row = $result->fetch_assoc();

                    echo $row["name"] . " (" . $userid_lookup[$row["uploader"]] . ")<br/>";


                    echo "Add score";
                    echo "<form action=\"#\" method=\"POST\">";
                    
                    echo "<select name=\"user\">";
                    foreach($userid_lookup as $id => $username)
                        echo "  <option value=\"" . $id . "\">" . $username . "</option>";
                    echo "</select>";

                    echo "<input type=\"number\" name=\"score\"/>";

                    echo "<input type=\"checkbox\" name=\"playplus\"/>";

                    echo "<input type=\"hidden\" name=\"level\" value=\"" . $row["id"] . "\"/>";

                    echo "<input type=\"hidden\" name=\"what\" value=\"add_score\"/>";
                    echo "</form>";
                }
            ?>
        </div>
    </body>
</html>