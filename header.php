<div>
    <a style="font-size:2em;font-weight:bold;display:inline-block;color:var(--foreground-color);text-decoration:none;" href="/">ThumpNet</a>
    <img src="images/beeble/beeble.png" class="beeble" id="beebleimage" onclick="randomBeeble();"/>
    <?php
        if(isset($_SESSION["id"]))
        {
            echo "<div>Logged in as: " . htmlspecialchars($_SESSION["username"]) . "</div>";

            if($_SESSION["permission_level"] >= 4)
            {
                echo "<form action=\"admin.php\">";
                echo "    <input type=\"submit\" value=\"Admin\"/>";
                echo "</form>";
            }

            echo "<form action=\"logout.php\">";
            echo "    <input type=\"submit\" value=\"Logout\"/>";
            echo "</form>";

            // Permission level 1 allows level score reviews
            if($_SESSION["permission_level"] >= 1)
            {
                include "api/db.php";
                $result = $mysqli->query("SELECT COUNT(*) as `count` FROM `scores_awaiting`");
                $row = $result->fetch_assoc();
                if($row["count"] > 0)
                    echo "There are pending score approvals. Click <a href=\"check_score_subs.php\">here</a> to check them.";
            }
        }
        else
        {
            echo "<form action=\"login.php\">";
            echo "    <input type=\"submit\" value=\"Login\"/>";
            echo "</form>";
        }
    ?>
</div>