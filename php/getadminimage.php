<?php
//Debugging 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$host = 'localhost';
$dbname = 'FinalProject';
$username = 'usuario2024';
$password = 'usuario2024';
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ID = $_GET['ID']; //Gets ID from GET

$stmt = $conn->prepare("SELECT Photo FROM Admins WHERE ID = ?");
$stmt->bind_param("s", $ID);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($photoContent);
$stmt->fetch();

header("Content-Type: image/png");
echo $photoContent;

$stmt->close();
$conn->close();
?>
