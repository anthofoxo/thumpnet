fetch("api/?resolve=user")
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
            let label = document.createElement("span");
            label.textContent = "Difficulty: ";
            label.style.fontWeight = "bold";

            let icon = document.createElement("img");
            icon.src = "images/D" + level.difficulty + ".png";
            icon.alt = "D" + level.difficulty;

            let difficulty = document.createElement("span");
            difficulty.textContent = "D" + level.difficulty;

            let element = document.createElement("div");
            element.appendChild(label);
            element.appendChild(icon);
            element.appendChild(difficulty);

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
            
            element.style.display = "block";
            element.style.padding = "0 0 2em 0";

            if(level.cdn)
            {
                element.textContent = "Download";
                element.href = "cdn/" + level.cdn;
                
            }
            else
            {
                element.textContent = "No Download Available";
                element.style.color = "red";
            }

            metdata.appendChild(element);
        }

        root.appendChild(metdata);

        container.appendChild(root);
    }
});