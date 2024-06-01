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

if(isset($_POST['ID']) && !empty($_POST['ID'])) {
    $ID = $_POST['ID']; //Gets ID from POST

    $stmt = $conn->prepare("DELETE FROM Teacher WHERE ID = ?");
    $stmt->bind_param("s", $ID);

    if($stmt->execute()) {
        echo "<script>
            alert('Teacher deleted successfully');
            window.location.href='/Projects/PF/index.php'; // Ajusta la redirección según sea necesario
        </script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Error: ID not provided";
}

$conn->close();
?>
