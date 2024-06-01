<?php
//This is a good practice, using a kinda like Observer model but in PHP. This allows us to call the connection in every php database use organically, faster and easier, making maintenance easier.
$host = 'localhost';
$dbname = 'FinalProject';
$username = 'usuario2024';
$password = 'usuario2024';
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//require_once 'db/db.php';
?>