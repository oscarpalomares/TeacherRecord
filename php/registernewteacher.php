<?php
//Debugging
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
$Password = $_POST['Password'];
$ID = $_POST['ID'];

//New way to handle Classes, Assignments, and Shift using checkboxes
$Classes = isset($_POST['ClassroomNumbers']) ? $_POST['ClassroomNumbers'] : [];
$Assignments = isset($_POST['AssignmentName']) ? $_POST['AssignmentName'] : [];
$Shifts = isset($_POST['ShiftField']) ? $_POST['ShiftField'] : [];

//Classes, Assignments and Shift are valued as JSONS. This is unpractical, but it was made like this just for skill show off. We must convert arrays to JSON strings
$ClassesJSON = json_encode($Classes);
$AssignmentsJSON = json_encode($Assignments);
$ShiftJSON = json_encode($Shifts);

$photoContent = NULL; //Just like Admin, we must start the variable before its use.

//Just as Admin, we check if everything is ok with the photo upload.
if ($_FILES['photo']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['photo']['tmp_name'])) {
    $tmpName = $_FILES['photo']['tmp_name'];
    $fp = fopen($tmpName, 'rb');
    $photoContent = fread($fp, filesize($tmpName));
    fclose($fp);
}

$stmt = $conn->prepare("INSERT INTO Teacher (FirstName, FirstSurname, SecondSurname, Birthday, Age, Career, Adress, PhoneNumber, Sex, MaritalStatus, Email, Password, ID, Classes, Assignments, Shift, Photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssississssssssb", $FirstName, $FirstSurname, $SecondSurname, $Birthday, $Age, $Career, $Adress, $PhoneNumber, $Sex, $MaritalStatus, $Email, $Password, $ID, $ClassesJSON, $AssignmentsJSON, $ShiftJSON, $photoContent);
if ($photoContent !== NULL) {
    $stmt->send_long_data(16, $photoContent); //It is known that when handling files like photos, its considered to be best to use directions instead of straight up sending the whole file, but for simplicity terms, whe are gonna use this approach.
}

//If everything goes good, registers the teacher, sends you an alert and redirects you to index.
if ($stmt->execute()) {
    echo "<script>alert('New Teacher registered successfully'); window.location.href='http://localhost/Projects/PF/index.php';</script>";
} else {
    echo "<script>alert('Error: " . addslashes($stmt->error) . "'); window.location.href='http://localhost/Projects/PF/registernewteacher.html';</script>";
}

$stmt->close();
$conn->close();
?>
