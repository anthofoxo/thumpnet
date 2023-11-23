<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css"/>
        <script src="build_level_list.js" defer></script>
    </head>
    <body>
        <div>
            This domain name is not final
        </div>
        <div>
        <h2>Info</h2>
            Thumpnet is a custom level host for <a href="https://thumpergame.com/">Thumper</a>.
            I'm <a href="discord://-/users/218415631479996417">@anthofoxo</a>, lead dev of the website and api.
            This is a succesor and more permanent solution to the efforts by Bigphish.

            To keep up with the thumper community and progress of this. Join the <a href="https://discord.gg/FU2X9z4ttJ">thumper discord</a>.

            <a href="https://docs.google.com/spreadsheets/d/19SbuARLhHfxTcZXDEGzxeQIdpJR0acTPTNtwrnwUtUI/edit?usp=sharing">Custom level spreadsheet.</a>
            <hr/>

            <h3>Todo:</h3>
            <ul>
                <li>Difficulty icons. Awaiting larger files or svg files</li>
                <li>Default thumbail</li>
                <li>Difficulty chart detailing</li>
                <li>Look into using Futura PT Heavy</li>
                <li>A versioning system for custom levels</li>
                <li>.innerHTML is being used, this is a security risk, prefer .textContent</li>
            </ul>

            <img src="images/Difficulty_Table.png" width="320"></img>

            <h2>Difficulty chart HTML table (wip)</h2>
            <?php include("difficulty_table.html");?>
            See: <a href="difficulty_table.html">External table<a> (Use this to make edits to the difficulty table)

            <a href="https://github.com/CocoaMix86/Thumper-Custom-Level-Editor/releases/tag/2.0">Thumper custom level editor 2.0</a>
            <a href="https://docs.google.com/document/d/1zwrpMhfugF7f_sxgpWUM9_cnOXtubOyFIqd7TCRryxM">Thumper manual 2.0</a>

            <div id="levels"></div>
        </div>
    </body>
</html>