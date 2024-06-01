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

$ID = $_GET['ID']; //GET ID

//Query for getting all the data from the selected teacher, then some error handling.
$stmt = $conn->prepare("SELECT * FROM Teacher WHERE ID = ?"); //If statement fails throws the error and dies.
if(!$stmt) {
    die("Error preparing statement: " . htmlspecialchars($conn->error));
}
$stmt->bind_param("s", $ID); //If theres something wrong with binding the param ID, throws error and dies.
if(!$stmt->execute()) {
    die("Error executing statement: " . htmlspecialchars($stmt->error));
}
$result = $stmt->get_result();
if(!$result) {
    die("Error getting results: " . htmlspecialchars($conn->error)); //If there isn't a result to show, throws an error and dies.
}
$teacherInfo = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Teacher info</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/styleteacherinfo.css">
    <script src="scripts/jsscriptteacherinfo.js"></script>
    <link rel="icon" href="img/lasalle.ico" type="image/ico">
</head>
<body>
    <div class="container mt-5 custom-background">
        <br><br><h2 class="text-center mb-4">Universidad La Salle</h2>
        <h2 class="text-center mb-4">Teachers file</h2><br>
    </div>
    
    <br>
    
    <div class="text-center">
    <div class="d-flex justify-content-center">
        <form action="php/deleteteacher.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this teacher?');" class="mr-2">
            <input type="hidden" name="ID" value="<?php echo htmlspecialchars($teacherInfo['ID']); ?>">
            <input type="submit" id="deleteteacher" value="Delete Teacher" class="btn btn-danger">
        </form>

        <input type="button" id="gobacktoindex" value="Return to Index" class="btn btn-success mr-2" onclick="OpenIndex()">

        <form action="editteacher.php" method="GET">
            <input type="hidden" name="ID" value="<?php echo htmlspecialchars($teacherInfo['ID']); ?>">
            <input type="submit" id="editteacher" value="Edit Teacher" class="btn btn-primary">
        </form>

    </div>

    <br>
    <div class="text-center">
        <h1 class="mb-0">Teacher Info</h1>
    </div>
    <br>

    <!-- Even here whe use a 3 column shrinkable auto-adjustable desieng depending on window size -->
    <div class="container">
        <div class="row">
            <!-- Column 1: Photo -->
            <div class="col-md-4 text-center">
                <?php if (!empty($teacherInfo['Photo'])): ?>
                    <img src="php/getteacherimage.php?ID=<?php echo $teacherInfo['ID']; ?>" alt="Teacher Photo" class="img-fluid">
                <?php endif; ?>
            </div>

            <!-- Column 2: Personal Data -->
            <div class="col-md-4">
                <h3>Personal Data</h3>
                <p>Fullname: <?php echo htmlspecialchars($teacherInfo['FirstName']) . " " . htmlspecialchars($teacherInfo['FirstSurname']) . " " . htmlspecialchars($teacherInfo['SecondSurname']); ?></p>
                <p>Birthday: <?php echo htmlspecialchars($teacherInfo['Birthday']); ?></p>
                <p><?php echo htmlspecialchars($teacherInfo['Age']); ?> Years Old</p>
                <p>Career: <?php echo htmlspecialchars($teacherInfo['Career']); ?></p>
                <p>Home Address: <?php echo htmlspecialchars($teacherInfo['Adress']); ?></p>
                <p>Personal PhoneNumber: <?php echo htmlspecialchars($teacherInfo['PhoneNumber']); ?></p>
                <p>Sex: <?php echo htmlspecialchars($teacherInfo['Sex']); ?></p>
                <p>Teacher's Marital Status: <?php echo htmlspecialchars($teacherInfo['MaritalStatus']); ?></p>
            </div>

            <!-- Column 3: Account Info -->
            <div class="col-md-4">
                <h3>Account Info</h3>
                <p>Email: <?php echo htmlspecialchars($teacherInfo['Email']); ?></p>
                <p>Password: <?php echo htmlspecialchars($teacherInfo['Password']); ?></p>
                <p>Unique KeyID: <?php echo htmlspecialchars($teacherInfo['ID']); ?></p>
                <br>
                <h3>School Info</h3>
                <p>Teacher's Classrooms: <?php echo htmlspecialchars($teacherInfo['Classes']); ?></p>
                <p>Teacher's Assignments: <?php echo htmlspecialchars($teacherInfo['Assignments']); ?></p>
                <p>Teacher's Shifts: <?php echo htmlspecialchars($teacherInfo['Shift']); ?></p>
            </div>
        </div>
    </div>
</body>
</html>