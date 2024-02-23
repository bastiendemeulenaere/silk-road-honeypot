<?php

$dbServer = getenv("DB_SERVER");
$dbUsername = getenv("DB_USERNAME");
$dbPassword = getenv("DB_PASSWORD");
$dbName = getenv("DB_NAME");

$conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);
    
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>