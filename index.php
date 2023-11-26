<?php session_start();?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <?php include "metadata.html";?>
        <title>ThumpNet</title>
        <link rel="preload" href="images/default_thumb.jpg" as="image"/>
        <link rel="preload" href="images/Loading.gif" as="image"/>
        <link rel="stylesheet" href="landing.css"/>
        <script src="build_level_list.js" defer></script>
        <script src="beeble_functions.js" defer></script>
    </head>
    <body>
        <div>
            <span style="font-size: 2em;font-weight: bold;">ThumpNet</span>
            <img src="images/beeble/beeble.png" class="beeble" id="beebleimage" onclick="randomBeeble();">
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
            <div style="margin-bottom:8px;">
                ThumpNet is a custom level host for <a href="https://thumpergame.com/">Thumper</a>.
                This is a succesor and more permanent solution to the efforts by Bigphish.
                I'm <a href="discord://-/users/218415631479996417">@anthofoxo</a>, lead dev of the website and api.
                Join the <a href="https://discord.gg/FU2X9z4ttJ">thumper discord</a>.

                <a href="https://github.com/CocoaMix86/Thumper-Custom-Level-Editor/releases/tag/2.0">Thumper custom level editor 2.0</a>
                <a href="https://docs.google.com/document/d/1zwrpMhfugF7f_sxgpWUM9_cnOXtubOyFIqd7TCRryxM">Thumper manual 2.0</a>
            </div>

            <span style="display:none;">
                <?php include("difficulty_table.html");?>
            </span>

            <div id="levels"></div>
        </div>
    </body>
</html>