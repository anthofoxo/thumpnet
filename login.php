<!DOCTYPE html>
<html lang="en-US">
    <head>
        <?php
            session_start();

            $redirect_success = "<meta http-equiv=\"refresh\" content=\"0;url=/\"/>";
            $redirect_failed = "<meta http-equiv=\"refresh\" content=\"0;url=?status=failed\"/>";

            if(isset($_SESSION["username"]))
            {
                echo $redirect_success;
                exit;
            }

            if(isset($_POST["username"]))
            {
                include "api/db.php";
                $stmt = $mysqli->prepare("SELECT `id`,`username`,`password` FROM `users` WHERE `username` = ?");
                $stmt->bind_param("s", $_POST["username"]);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result->num_rows != 1)
                {
                    echo $redirect_failed;
                    exit;
                }
                $row = $result->fetch_assoc();
    
                $settings = parse_ini_file("api/config.ini", true);
                
                if(password_verify($settings["security"]["secretkey"] . $_POST["password"], $row["password"]))
                {
                    $_SESSION["id"] = $row["id"];
                    $_SESSION["username"] = $row["username"];
                    echo $redirect_success;
                }
                else
                    echo $redirect_failed;

                unset($settings);
            }
        ?>

        <?php include "metadata.html";?>
    </head>
    <body>
        <h1>Login Form</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="username"></input><br/>
            <input type="password" name="password" placeholder="password"></input><br/>
            <input type="submit" value="Login"></input>
        </form>
    </body>
</html>