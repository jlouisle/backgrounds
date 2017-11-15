<?php

$server = "127.0.0.1";
$username = "backgrounds";
$password = "backgrounds";
$database = "backgrounds";

$mysqli = new mysqli($server, $username, $password, $database);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
