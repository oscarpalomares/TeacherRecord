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

if (isset($_GET['AssignmentName']) && !empty($_GET['AssignmentName'])) {
    $AssignmentName = urldecode($_GET['AssignmentName']); //If data from GET exist, beggins a try

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("DELETE FROM Assignments WHERE AssignmentName = ?"); //First, deletes the assignment from table Assignments
        $stmt->bind_param("s", $AssignmentName);
        $stmt->execute();
        $stmt->close();

        //Then, deletes the selected assignment from all Teachers that have that assignment.
        $stmt2 = $conn->prepare("UPDATE Teacher SET Assignments = JSON_REMOVE(Assignments, JSON_UNQUOTE(JSON_SEARCH(Assignments, 'one', ?))) WHERE JSON_CONTAINS(Assignments, ?, '$')");
        $stmt2->bind_param("ss", $AssignmentName, json_encode($AssignmentName)); //Since Assignment is JSON, we must encode it back.
        $stmt2->execute();
        $stmt2->close();

        $conn->commit();

        echo "<script>
            alert('Assignment deleted successfully');
            window.location.href='/Projects/PF/index.php'; // Ajusta la redirección según sea necesario
        </script>";
    } catch (Exception $e) { //If something goes wrong, handles the error and performs a Rollback.
        $conn->rollback(); //Rollback is a good practice here becasue we are handling a lot of information on many records. If something goes wrong, performs a rollback to a past state.
        //Exception catching will be used in assignment and classroom deletion
        echo "Error deleting record: " . $e->getMessage();
    }
} else {
    echo "Error: Assignment name not provided";
}

$conn->close();
?>
