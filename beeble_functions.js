function randomBeeble()
{
    let rnd = getRandomInt(11);
    if (rnd < 9)
        document.getElementById("beebleimage").src = `images/beeble/${rnd}.png`;
    else
        document.getElementById("beebleimage").src = `images/beeble/${rnd}.gif`;
}

function getRandomInt(max)
{
    return Math.floor(Math.random() * max);
}