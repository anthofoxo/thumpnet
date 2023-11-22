<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css"/>
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

            <script>
                fetch("https://thumpnet.anthofoxo.xyz/api/?resolve=user")
                .then((response)=>response.json())
                .then((response)=>
                {
                    let levels = response.levels;

                    let container = document.getElementById("levels");

                    for(level of levels)
                    {
                        let root = document.createElement("div");

                        {
                            let element = document.createElement("img");
                            if(level.thumb) element.src = "cdn/" + level.thumb;
                            else element.alt = "No thumbnail";
                            root.appendChild(element);
                        }

                        let metdata = document.createElement("div");

                        {
                            let element = document.createElement("h4");
                            element.textContent = level.name;
                            metdata.appendChild(element);
                        }

                        {
                            let element = document.createElement("h5");
                            element.textContent = level.description;
                            metdata.appendChild(element);
                        }

                        {
                            let element = document.createElement("div");
                            element.innerHTML = "<b>Difficulty: </b>" + level.difficulty;
                            metdata.appendChild(element);
                        }

                        {
                            let element = document.createElement("div");

                            let author_strings = [];

                            for(author of level.authors)
                                author_strings.push(response.resolve.user[author]);

                            element.innerHTML = "<b>Authors: </b>" + author_strings;
                            metdata.appendChild(element);
                        }

                        {
                            let element = document.createElement("div");
                            element.innerHTML = "<b>Uploaded by: </b>" + response.resolve.user[level.uploader];
                            metdata.appendChild(element);
                        }

                        {
                            let element = document.createElement("div");
                            if(level.extra) element.innerHTML = "<b>Bpm: </b>" + level.extra.bpm;
                            metdata.appendChild(element);
                        }

                        {
                            let element = document.createElement("div");
                            if(level.extra) element.innerHTML = "<b>Num sublevels: </b>" + level.extra.sublevels;
                            metdata.appendChild(element);
                        }

                        {
                            let element = document.createElement("a");
                            element.textContent = "Download";
                            element.href = "cdn/" + level.cdn;
                            element.style.display = "block";
                            element.style.padding = "0 0 2em 0";
                            metdata.appendChild(element);
                        }

                        root.appendChild(metdata);

                        container.appendChild(root);
                    }

                });
            </script>
        </div>
    </body>
</html>