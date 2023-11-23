<?php
$settings = parse_ini_file('mysqli.ini', true);
$mysqli = new mysqli($settings['db']['hostname'], $settings['db']['username'], $settings['db']['password'], $settings['db']['database']);
unset($settings);
?>