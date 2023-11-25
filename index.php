<?php session_start();?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>ThumpNet</title>
        <meta name="description" content="ThumpNet"/>
        <meta name="keywords" content="Thumper,ThumpNet"/>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="preload" href="default_thumb.jpg" as="image"/>
        <link rel="stylesheet" href="global.css"/>
        <link rel="stylesheet" href="landing.css"/>
        <link rel="icon" type="image/png" href="favicon.png"/>

        <script src="build_level_list.js" defer></script>
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
            ThumpNet is a custom level host for <a href="https://thumpergame.com/">Thumper</a>.
            This is a succesor and more permanent solution to the efforts by Bigphish.
            I'm <a href="discord://-/users/218415631479996417">@anthofoxo</a>, lead dev of the website and api.
            Join the <a href="https://discord.gg/FU2X9z4ttJ">thumper discord</a>.

            <a href="https://github.com/CocoaMix86/Thumper-Custom-Level-Editor/releases/tag/2.0">Thumper custom level editor 2.0</a>
            <a href="https://docs.google.com/document/d/1zwrpMhfugF7f_sxgpWUM9_cnOXtubOyFIqd7TCRryxM">Thumper manual 2.0</a>

            <?php include("difficulty_table.html");?>

            <h1>Levels</h1>
            <div id="levels"></div>
        </div>
    </body>
</html>