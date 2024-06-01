<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "usuario2024";
$password = "usuario2024";
$dbname = "FinalProject";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$FirstName = $_POST['FirstName'];
$FirstSurname = $_POST['FirstSurname'];
$SecondSurname = $_POST['SecondSurname'];
$Birthday = $_POST['Birthday'];
$Age = $_POST['Age'];
$Sex = $_POST['Sex'];
$Email = $_POST['Email'];
$Password = $_POST['Password'];
$SuperUser = isset($_POST['SuperUser']) ? 1 : 0;
$ID = $_POST['ID'];
$photoContent = null;

if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['photo']['tmp_name'])) {
    $tmpName = $_FILES['photo']['tmp_name'];
    $photoContent = file_get_contents($tmpName);
}

$stmt = $conn->prepare("UPDATE Admins SET FirstName=?, FirstSurname=?, SecondSurname=?, Birthday=?, Age=?, Sex=?, Email=?, Password=?, SuperUser=?, Photo=? WHERE ID=?");
if (!$stmt) {
    die("Error preparing statement: " . htmlspecialchars($conn->error));
}

$null = NULL; // Necessary for binding the blob
$stmt->bind_param("ssssisssibs", $FirstName, $FirstSurname, $SecondSurname, $Birthday, $Age, $Sex, $Email, $Password, $SuperUser, $null, $ID);

// Send long data for the blob
if ($photoContent !== null) {
    $stmt->send_long_data(9, $photoContent);
}

if ($stmt->execute()) {
    echo "<script>alert('Admin edited successfully'); window.location.href='http://localhost/Projects/PF/index.php';</script>";
} else {
    echo "Error updating Admin: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
