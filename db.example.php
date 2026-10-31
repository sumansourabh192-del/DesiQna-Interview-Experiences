<?php
$host = "localhost";
$username = "root";
$password = "YOUR_DATABASE_PASSWORD";
$database = "desiqna";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed.");
}
?>
