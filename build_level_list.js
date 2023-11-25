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
            let element = document.createElement("div");
            element.textContent = level.name;
            root.appendChild(element);
        }

        {
            let donwloadbutton = document.createElement("div");
            donwloadbutton.className = "downloadbutton"

            {
                let element = document.createElement("a");

                if(level.has_content)
                {
                    element.textContent = "Download";
                    element.href = "cdn/" + level.cdn + ".zip";
                }
                else
                {
                    element.textContent = "No Download Available";
                    element.style.color = "red";
                }

                donwloadbutton.appendChild(element);
            }
            root.appendChild(donwloadbutton);
        }

        {

            let element = document.createElement("img");
            element.className = "stylingimg";
            element.src = "Loading.gif";

            if(level.has_thumb)
            {
                
                let img = new Image();
                img.onload = function()
                {
                    element.src = img.src;
                    element.alt = level.name;
                }
                img.onerror = function()
                {
                    element.src = "default_thumb.jpg";
                    element.alt = "Default thumbnail"
                }

                img.src = "cdn/" + level.cdn + ".png";
            }
            else
            {
                element.src = "default_thumb.jpg";
                element.alt = "Default thumbnail"
            }

            root.appendChild(element);
        }

        let metdata = document.createElement("div");
        metdata.className = "stylingmetadata";

        {
            let element = document.createElement("div");
            element.textContent = level.description;
            element.style.cssText = 'font-style:italic;';
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

        root.appendChild(metdata);

        container.appendChild(root);
    }
});