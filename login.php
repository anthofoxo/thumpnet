<?php session_start();?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta name="robots" content="noindex"/>
        <?php
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
                $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE `username` = ?");
                $stmt->bind_param("s", $_POST["username"]);
                $stmt->execute();
                $result = $stmt->get_result();
                if($result->num_rows != 1)
                {
                    echo $redirect_failed;
                    exit;
                }
                $row = $result->fetch_assoc();
                
                if(password_verify($config["security"]["secretkey"] . $_POST["password"], $row["password"]))
                {
                    $_SESSION["id"] = $row["id"];
                    $_SESSION["username"] = $row["username"];
                    $_SESSION["permission_level"] = $row["permission_level"];
                    echo $redirect_success;
                }
                else
                {
                    echo $redirect_failed;
                }
            }
        ?>

        <?php include "metadata.html";?>

        <style>
            body>div
            {
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: .5em;
            }
            form
            {
                display: flex;
                flex-direction: column;
                justify-content: center;
                gap: .5em;
            }
        </style>
    </head>
    <body>
        <div>
            <span style="font-size:2em;font-weight:bold;">Login Form</span>
            <span id="message" style="color:red;font-weight:bold;"></span>
            <form method="POST">
                <input type="text" name="username" placeholder="username" autofocus></input>
                <input type="password" name="password" placeholder="password"></input>
                <div>
                    <input type="submit" value="Login"></input>
                    <input type="button" value="Cancel" onclick='window.location.href = "/";'></input>
                </div>
                <span>To create an account see <a href="discord://-/users/218415631479996417">@anthofoxo</a> on Discord.</span>
            </form>
        </div>
        <script>
            const urlParams = new URLSearchParams(window.location.search);
            if("failed" === urlParams.get("status"))
            {
                document.getElementById("message").textContent = "Failed to login";
            }
        </script>
    </body>
</html>