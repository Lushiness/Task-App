<?php
$database="taskapp";
$server= "localhost";
$username = "root";
$password = "newpassword";
$conn = new mysqli($server, $username, $password, $database, 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>