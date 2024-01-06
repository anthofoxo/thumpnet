<?php
include "db.php";

$result = $mysqli->query("SELECT * FROM levels ORDER BY id DESC");

$should_resolve_users = isset($_GET["resolve"]) && $_GET["resolve"] == "user";

for ($row_no = 0; $row_no < $result->num_rows; $row_no++)
{
    $result->data_seek($row_no);
    $row = $result->fetch_assoc();
    
    $element = array();

    // Required fields
    $element["id"] = intval($row["id"]);
    $element["uploader"] = intval($row["uploader"]);

    // Optional fields
    $element["name"] = $row["name"] ?? null;
    $element["content"] = $row["content"] ?? null;
    $element["thumbnail"] = $row["thumbnail"] ?? null;
    $element["difficulty"] = intval($row["difficulty"]) ?? null;
    $element["description"] = $row["description"] ?? null;

    $element["bpm"] = $row["bpm"];
    $element["sublevels"] = $row["sublevels"] ?? null;
    $element["song"] = $row["song"] ?? null;

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
    $result = $mysqli->query("SELECT `id`,`username` FROM `users`");

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