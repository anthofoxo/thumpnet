<?php
include "db.php";

$result = $mysqli->query("SELECT * FROM levels");

$should_resolve_users = isset($_GET["resolve"]) && $_GET["resolve"] == "user";

for ($row_no = 0; $row_no < $result->num_rows; $row_no++)
{
    $result->data_seek($row_no);
    $row = $result->fetch_assoc();
    
    $element = array();

    $element["id"] = $row["id"];
    $element["name"] = $row["name"];
    $element["cdn"] = $row["cdn"];
    $element["difficulty"] = $row["difficulty"];
    $element["description"] = $row["description"];

    $element["has_thumb"] = $row["has_thumb"];
    $element["has_content"] = $row["has_content"];

    $element["uploader"] = $row["uploader"];

    if ($should_resolve_users)
        $user_ids[$row["uploader"]] = "";

    if(isset($row["authors"]))
        $authors = json_decode($row["authors"]);

    $element["authors"] = $authors;

    if ($should_resolve_users)
        foreach($authors as $author)
            $user_ids[$author] = "";

    if(isset($row["extra"]))
        $element["extra"] = json_decode($row["extra"]);

    $reply["levels"][$row_no] = $element;
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