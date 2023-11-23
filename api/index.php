<?php
$settings = parse_ini_file('mysqli.ini', true);
$mysqli = new mysqli($settings['db']['hostname'], $settings['db']['username'], $settings['db']['password'], $settings['db']['database']);

$result = $mysqli->query("SELECT * FROM levels");

$should_resolve_users = isset($_GET["resolve"]) && $_GET["resolve"] == "user";

for ($row_no = 0; $row_no < $result->num_rows; $row_no++)
{
    $result->data_seek($row_no);
    $row = $result->fetch_assoc();
    
    $reply["levels"][$row_no]["id"] = $row["id"];
    $reply["levels"][$row_no]["uploader"] = $row["uploader"];

    if ($should_resolve_users)
        $user_ids[$row["uploader"]] = "";

    $reply["levels"][$row_no]["name"] = $row["name"];
    $reply["levels"][$row_no]["cdn"] = $row["cdn"];
    $reply["levels"][$row_no]["difficulty"] = $row["difficulty"];
    $reply["levels"][$row_no]["description"] = $row["description"];
    $reply["levels"][$row_no]["thumb"] = $row["thumb"];

    $authors = json_decode($row["authors"]);

    if ($should_resolve_users)
        foreach($authors as $author)
            $user_ids[$author] = "";

   
    $reply["levels"][$row_no]["authors"] = $authors;

    if(isset($row["extra"]))
        $reply["levels"][$row_no]["extra"] = json_decode($row["extra"]);
}

// Resovle all user ids
if ($should_resolve_users)
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