<?php
$settings = parse_ini_file('mysqli.ini', true);
$mysqli = new mysqli($settings['db']['hostname'], $settings['db']['username'], $settings['db']['password'], $settings['db']['database']);

$result = $mysqli->query("SELECT * FROM levels");

for ($row_no = 0; $row_no < $result->num_rows; $row_no++)
{
    $result->data_seek($row_no);
    $row = $result->fetch_assoc();
    
    $reply["levels"][$row_no]["id"] = $row["id"];
    $reply["levels"][$row_no]["uploader"] = $row["uploader"];

    if ($_GET["resolve"] == "user")
        $user_ids[$row["uploader"]] = "";

    $reply["levels"][$row_no]["name"] = $row["name"];
    $reply["levels"][$row_no]["cdn"] = $row["cdn"];
    $reply["levels"][$row_no]["difficulty"] = $row["difficulty"];
    $reply["levels"][$row_no]["description"] = $row["description"];
    $reply["levels"][$row_no]["thumb"] = $row["thumb"];

    $authors = json_decode($row["authors"]);

    if ($_GET["resolve"] == "user")
        foreach($authors as $author)
            $user_ids[$author] = "";

   
    $reply["levels"][$row_no]["authors"] = $authors;
    $reply["levels"][$row_no]["extra"] = json_decode($row["extra"]);
}

// Resovle all user ids
if ($_GET["resolve"] == "user")
{
    $result = $mysqli->query("SELECT id,username FROM users");

    for ($row_no = 0; $row_no < $result->num_rows; $row_no++)
    {
        $result->data_seek($row_no);
        $row = $result->fetch_assoc();

        if(isset($user_ids[$row["id"]]))
            $reply["resolve"]["user"][$row["id"]] = $row["username"];
    }
}

echo json_encode($reply);
?>