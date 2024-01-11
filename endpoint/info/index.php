<?php
$response["dl"] = "cdn";
$response["accept"][0] = "0.1.0";
header("Content-Type: application/json");
echo json_encode($response);
?>