<?php
//Debug
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "usuario2024";
$password = "usuario2024";
$dbname = "FinalProject";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$stmt = $conn->prepare("INSERT INTO Classes (ClassroomNumber) VALUES (?)");

$stmt->bind_param("i", $ClassroomNumber);

$ClassroomNumber = $_POST['ClassroomNumber'];

if ($stmt->execute()) {
    echo "<script>
        alert('New Classroom Created Successfully');
        window.location.href='http://localhost/Projects/PF/index.php';
    </script>";
} else {
    echo "<script>
        alert('Error: " . addslashes($stmt->error) . "');
        window.location.href='http://localhost/Projects/PF/index.php';
    </script>";
}

$stmt->close();
$conn->close();
?>