<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>ThumpNet</title>
        <meta name="description" content="ThumpNet"/>
        <meta name="keywords" content="Thumper,ThumpNet"/>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="stylesheet" href="style.css"/>
        <link rel="icon" type="image/png" href="favicon.png"/>
        <script src="build_level_list.js" defer></script>
    </head>
    <body>
        <div>
            <h3>ThumpNet</h3>
        </div>
        <div>
            ThumpNet is a custom level host for <a href="https://thumpergame.com/">Thumper</a>.
            This is a succesor and more permanent solution to the efforts by Bigphish.
            I'm <a href="discord://-/users/218415631479996417">@anthofoxo</a>, lead dev of the website and api.
            Join the <a href="https://discord.gg/FU2X9z4ttJ">thumper discord</a>.

            <hr/>

            <h3>Todo:</h3>
            <ul>
                <li>Difficulty icons. Awaiting larger files or svg files</li>
                <li>Default thumbail</li>
                <li>Difficulty chart detailing</li>
                <li>A versioning system for custom levels</li>
                <li>.innerHTML is being used, this is a security risk, prefer .textContent</li>
            </ul>

            <img src="images/Difficulty_Table.png" width="320"></img>

            <h2>Difficulty chart HTML table (wip)</h2>
            <?php include("difficulty_table.html");?>
            See: <a href="difficulty_table.html">External table</a> (Use this to make edits to the difficulty table)

            <a href="https://github.com/CocoaMix86/Thumper-Custom-Level-Editor/releases/tag/2.0">Thumper custom level editor 2.0</a>
            <a href="https://docs.google.com/document/d/1zwrpMhfugF7f_sxgpWUM9_cnOXtubOyFIqd7TCRryxM">Thumper manual 2.0</a>

            <div id="levels"></div>
        </div>
    </body>
</html>