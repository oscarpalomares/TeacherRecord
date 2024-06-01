<?php
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

$FirstName = $_POST['FirstName'];
$FirstSurname = $_POST['FirstSurname'];
$SecondSurname = $_POST['SecondSurname'];
$Birthday = $_POST['Birthday'];
$Age = $_POST['Age'];
$Career = $_POST['Career'];
$Adress = $_POST['Adress'];
$PhoneNumber = $_POST['PhoneNumber'];
$Sex = $_POST['Sex'];
$MaritalStatus = $_POST['MaritalStatus'];
$Email = $_POST['Email'];
$Password = $_POST['Password']; // Consider hashing here

// New way to handle Classes, Assignments, and Shift using checkboxes
$Classes = isset($_POST['ClassroomNumbers']) ? $_POST['ClassroomNumbers'] : [];
$Assignments = isset($_POST['AssignmentName']) ? $_POST['AssignmentName'] : [];
$Shifts = isset($_POST['ShiftField']) ? $_POST['ShiftField'] : [];

// Convert arrays to JSON strings
$ClassesJSON = json_encode($Classes);
$AssignmentsJSON = json_encode($Assignments);
$ShiftJSON = json_encode($Shifts);

$ID = $_POST['ID'];

$photoContent = NULL;
if ($_FILES['photo']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['photo']['tmp_name'])) {
    $tmpName = $_FILES['photo']['tmp_name'];
    $photoContent = file_get_contents($tmpName);
}

$stmt = $conn->prepare("UPDATE Teacher SET FirstName=?, FirstSurname=?, SecondSurname=?, Birthday=?, Age=?, Career=?, Adress=?, PhoneNumber=?, Sex=?, MaritalStatus=?, Email=?, Password=?, Classes=?, Assignments=?, Shift=?, Photo = ? WHERE ID=?");
$stmt->bind_param("ssssississsssssbs", $FirstName, $FirstSurname, $SecondSurname, $Birthday, $Age, $Career, $Adress, $PhoneNumber, $Sex, $MaritalStatus, $Email, $Password, $ClassesJSON, $AssignmentsJSON, $ShiftJSON, $photoContent, $ID);
if ($photoContent !== NULL) {
    $stmt->send_long_data(15, $photoContent); // Asegúrate que el índice es correcto
}

if ($stmt->execute()) {
    echo "<script>alert('Teacher edited successfully'); window.location.href='http://localhost/Projects/PF/index.php';</script>";
} else {
    echo "Error updating teacher: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
