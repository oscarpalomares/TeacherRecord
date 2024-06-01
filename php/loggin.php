<?php
//For debugging.
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

//Handles the data sent via POST request.
$Email = isset($_POST['Email']) ? $_POST['Email'] : '';
$Password = isset($_POST['Password']) ? $_POST['Password'] : '';

//The correct aproach for a password and email verification, would be using Compare function with hashed user data, but for simplicity and example terms, im not going to encyrpt anything. (VULNERABILITY)
$sql = "SELECT FirstName, SuperUser, Password FROM Admins WHERE Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $Email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $storedPassword = $row['Password']; 

    //If found, compares user data 
    if ($_POST['Password'] === $storedPassword) {
        //If the data is valid, returns you to index.php and sends via SESSION variables important information relating the logged in user.
        $_SESSION['FirstName'] = $row['FirstName'];
        $_SESSION['SuperUser'] = $row['SuperUser'];

        header("Location: http://localhost/Projects/PF/index.php");
        exit();
    } else {
        echo "<script>alert('Incorrect password.'); window.location.href=' http://localhost/Projects/PF/loggin.html';</script>";
    }
} else {
    echo "<script>alert('Email not found.'); window.location.href=' http://localhost/Projects/PF/loggin.html';</script>";
}
//If user is not found or credentials do not match, returns you to login with an alert (Error handling).

$stmt->close();
$conn->close();

?>
