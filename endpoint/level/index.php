<?php
$request = json_decode(stripslashes(file_get_contents("php://input")), true);

$version = "0.1.0";

if ($request == null) {
    $response = [];
    $response["com"]["error"] = "Invalid request body";
    $response["com"]["version"] = $version;
    http_response_code(400);
    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}

if (!isset($request["com"]["accept"])) {
    $response = [];
    $response["com"]["error"] = "Cannot determine accepted versions";
    $response["com"]["version"] = $version;
    http_response_code(400);
    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}

$accepted = $request["com"]["accept"];

if (!in_array($version, $accepted)){
    $response = [];
    $response["com"]["error"] = "Unsupported version";
    $response["com"]["version"] = $version;
    http_response_code(400);
    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}

$response = [];
$response["com"]["version"] = $version;

$offset = $request["offset"] ?? 0;
$limit = $request["limit"] ?? 10;

include "../../api/db.php"; // Connect

$resolve_level = isset($request["resolve"]) && in_array("level", $request["resolve"]);
$resolve_user = isset($request["resolve"]) && in_array("user", $request["resolve"]);

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

$stmt = $mysqli->prepare("SELECT * FROM levels ORDER BY id DESC LIMIT ?, ?");
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

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