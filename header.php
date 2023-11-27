<div>
    <a style="font-size:2em;font-weight:bold;display:inline-block;color:var(--foreground-color);text-decoration:none;" href="/">ThumpNet</a>
    <img src="images/beeble/beeble.png" class="beeble" id="beebleimage" onclick="randomBeeble();"/>
    <?php
        if(isset($_SESSION["username"]))
        {
            echo "<div>Logged in as: " . htmlspecialchars($_SESSION["username"]) . "</div>";

            if($_SESSION["permission_level"] > 0)
            {
                echo "<form action=\"admin.php\">";
                echo "    <input type=\"submit\" value=\"Admin\"/>";
                echo "</form>";
            }

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