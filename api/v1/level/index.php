<?php
$request = json_decode(stripslashes(file_get_contents("php://input")), true);

if ($request == null) {
    $response = [];
    $response["error"] = "Invalid request body";
    http_response_code(400);
    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}

$response = [];
$response["warnings"] = [];

$offset = $request["offset"] ?? 0;
$limit = $request["limit"] ?? 10;

if($limit > 100) {
    $limit = 100;
    $response["warnings"][] = "limit too high, capped to 100";
}

$filter = $request["filter"] ?? "";
$sort = $request["sort"] ?? "";

$sort_dir = "";

if($filter == "") {
    $sort_sql = "`id`";
    $sort_dir = "desc";
}
else {
    $sort_sql = "LENGTH(`name`)";
    $sort_dir = "asc";
}

if ($sort == "relevance") $sort_sql = "LENGTH(`name`)";
else if ($sort == "alphabetical") $sort_sql = "`name`";
else if ($sort == "timestamp") $sort_sql = "`id`";
else if ($sort == "difficulty") $sort_sql = "`difficulty`";

$filter = explode(" ", $filter);

if(isset($request["sort_dir"])) {
    if("asc" == $request["sort_dir"]) $sort_dir = "ASC";
    if("desc" == $request["sort_dir"]) $sort_dir = "DESC";
}

include "../../db.php";

$resolve_level = isset($request["expand"]) && in_array("level", $request["expand"]);
$resolve_user = isset($request["expand"]) && in_array("user", $request["expand"]);

$users = array();
if ($resolve_user) {
    $result = $mysqli->query("SELECT id, username FROM users");

    for ($row_no = 0; $row_no < $result->num_rows; $row_no++)
    {
        $result->data_seek($row_no);
        $row = $result->fetch_assoc();
        $users[$row["id"]] = $row["username"];
    }
}

$result = "";

if(count($filter) > 0) {
    $query = "SELECT * FROM `levels` WHERE `name` LIKE CONCAT('%', ?, '%')";

    for($i = 1; $i < count($filter); $i += 1) {
        $query .= "AND `name` LIKE CONCAT('%', ?, '%') ";
    }
    
    $query .= "ORDER BY " . $sort_sql . " " . $sort_dir . " LIMIT ?, ?";

    $bindtypes = "";
    $vars = array();

    for($i = 0; $i < count($filter); $i++) {
        $bindtypes .= "s";
        $vars[] = $filter[$i];
    }

    $bindtypes .= "ii";
    $vars[] = $offset;
    $vars[] = $limit;

    $stmt = $mysqli->prepare($query);
    $stmt->bind_param($bindtypes, ...$vars);
    $stmt->execute();
    $result = $stmt->get_result();
}
else {
    $stmt = $mysqli->prepare("SELECT * FROM levels ORDER BY " . $sort_sql . " " . $sort_dir . " LIMIT ?, ?");
    $stmt->bind_param("ii", $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
}

for ($row_no = 0; $row_no < $result->num_rows; $row_no++)
{
    $result->data_seek($row_no);
    $row = $result->fetch_assoc();

    if ($resolve_level) {
         
        $response["levels"][$row_no] = $row;
        if(isset($row["authors"])) $response["levels"][$row_no]["authors"] = json_decode($row["authors"]);
        
        if($resolve_user) {
            $response["levels"][$row_no]["uploader"] = array();
            $response["levels"][$row_no]["uploader"]["id"] = $row["uploader"];
            $response["levels"][$row_no]["uploader"]["username"] = $users[$row["uploader"]];

            $func = function(int $value) use($users) {
                return [
                    "id" =>  $value,
                    "username" => $users[$value],
                ];
            };

            if(isset($row["authors"])) {

                $response["levels"][$row_no]["authors"] = array_map($func, $response["levels"][$row_no]["authors"]);

            }
        }

    } else {
        $response["levels"][$row_no] = $row["id"];
    }
}

$result = $mysqli->query("SELECT COUNT(*) as count FROM levels");
$row = $result->fetch_assoc();
$response["count"] = $row["count"];

header("Content-Type: application/json");
echo json_encode($response);
?>