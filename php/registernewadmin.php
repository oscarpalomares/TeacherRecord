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

//Checks if the uploaded photo via session variable "FILES" has no errors or problems.
if ($_FILES['photo']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['photo']['tmp_name'])) { //Photo is the "name" in the form
    // Abrir el archivo
    $tmpName = $_FILES['photo']['tmp_name'];
    $fp = fopen($tmpName, 'rb'); // reads Binary
    $photoContent = fread($fp, filesize($tmpName));
    fclose($fp);
}

$stmt = $conn->prepare("INSERT INTO Admins (FirstName, FirstSurname, SecondSurname, Birthday, Age, Sex, Email, Password, ID, Photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$null = NULL; // Start the variable for its use.
$stmt->bind_param("ssssissssb", $FirstName, $FirstSurname, $SecondSurname, $Birthday, $Age, $Sex, $Email, $Password, $ID, $null);

$FirstName = $_POST['FirstName'];
$FirstSurname = $_POST['FirstSurname'];
$SecondSurname = $_POST['SecondSurname'];
$Birthday = $_POST['Birthday'];
$Age = $_POST['Age'];
$Sex = $_POST['Sex'];
$Email = $_POST['Email'];
$Password = $_POST['Password'];
$ID = $_POST['ID'];

$stmt->send_long_data(9, $photoContent); //It is known that when handling files like photos, its considered to be best to use directions instead of straight up sending the whole file, but for simplicity terms, whe are gonna use this approach.

if ($stmt->execute()) {
    echo "<script>
        alert('New user created successfully');
        window.location.href='http://localhost/Projects/PF/loggin.html';
    </script>";
} else {
    echo "<script>
        alert('Error: " . addslashes($stmt->error) . "');
        window.location.href='http://localhost/Projects/PF/registernewadmin.html';
    </script>";
}

$stmt->close();
$conn->close();
?>