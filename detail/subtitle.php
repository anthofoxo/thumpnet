<?php
session_start();
if(isset($_SESSION["id"]))
{
    echo "<div>Logged in as: " . htmlspecialchars($_SESSION["username"]) . "</div>";

    if($_SESSION["permission_level"] >= 4)
    {
        echo '<form action="admin.php">';
        echo '    <input type="submit" value="Admin"/>';
        echo '</form>';
    }

    if($_SESSION["permission_level"] >= 2)
    {
        echo '<button hx-get="/upload_level.html" hx-target="#content">Upload Level</button>';
    }

    // We want a full page reload here, this will ensure anything with higher level accesses not be shown
    echo '<form action="logout.php">';
    echo '    <input type="submit" value="Logout"/>';
    echo '</form>';

    // Permission level 1 allows level score reviews
    if($_SESSION["permission_level"] >= 1)
    {
        include "../api/db.php";
        $result = $mysqli->query("SELECT COUNT(*) as `count` FROM `scores_awaiting`");
        $row = $result->fetch_assoc();
        if($row["count"] > 0)
            echo 'There are pending score approvals. Click <a href="check_score_subs.php">here</a> to check them.';
    }
}
else
{
    echo '<form hx-post="login_validate.php" hx-target="#header" style="display:inline;">';
    echo '  <input type="text" name="username" placeholder="username" autofocus></input>';
    echo '  <input type="password" name="password" placeholder="password"></input>';
    echo '  <input type="submit" value="Login"></input>';
    echo '</form>';
    echo '<span>To create an account see <a href="discord://-/users/218415631479996417">@anthofoxo</a> on Discord.</span>';
}
?>