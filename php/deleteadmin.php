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

//Get ID from POST
if(isset($_POST['ID']) && !empty($_POST['ID'])) {
    $ID = $_POST['ID'];

    $stmt = $conn->prepare("DELETE FROM Admins WHERE ID = ?");
    $stmt->bind_param("s", $ID);

    if($stmt->execute()) { //If everything was found, shows Alert window of success.
        echo "<script>
            alert('Admin deleted successfully');
            window.location.href='/Projects/PF/index.php';
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
