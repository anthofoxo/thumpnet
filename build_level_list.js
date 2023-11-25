function CreateLabeledText(label, data)
{
    let dom_container = document.createElement("div");

    if(data != undefined)
    {
        let dom_label = document.createElement("span");
        let dom_data = document.createElement("span");

        dom_label.textContent = label + ": ";
        dom_label.style.fontWeight = "bold";

        dom_data.textContent = data;

        dom_container.appendChild(dom_label);
        dom_container.appendChild(dom_data);
    }

    return dom_container;
}

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
            let element = document.createElement("img");
            element.src = "Loading.gif";

            if(level.has_thumb)
            {
                
                let img = new Image();
                img.onload = function()
                {
                    element.src = img.src;
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

        // Level description
        {
            let element = document.createElement("div");
            element.textContent = level.description;
            element.classList.add("level_description");
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
            let author_strings = [];

            for(author of level.authors)
                author_strings.push(response.resolve.user[author]);

            metdata.appendChild(CreateLabeledText("Authors", author_strings));
        }

        metdata.appendChild(CreateLabeledText("Uploaded by", response.resolve.user[level.uploader]));
        metdata.appendChild(CreateLabeledText("Bpm", level.extra?.bpm));
        metdata.appendChild(CreateLabeledText("Num sublevels", level.extra?.sublevels));
        
        {
            let element = document.createElement("a");
            
            element.style.display = "block";
            element.style.padding = "0 0 2em 0";

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

            metdata.appendChild(element);
        }

        root.appendChild(metdata);

        container.appendChild(root);
    }
});