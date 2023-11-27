<?php
$config = parse_ini_file("config.ini", true);
$mysqli = new mysqli($config["db"]["hostname"], $config["db"]["username"], $config["db"]["password"], $config["db"]["database"]);
?>