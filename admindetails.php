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

$ID = $_GET['ID']; //Handles the data ID via GET Request

//Selects the info from the ID received via GET Request, this is an error handling section.
$stmt = $conn->prepare("SELECT * FROM Admins WHERE ID = ?"); 
if(!$stmt) {
    die("Error preparing statement: " . htmlspecialchars($conn->error)); //If statement fails throws the error and dies.
}
$stmt->bind_param("s", $ID);
if(!$stmt->execute()) {
    die("Error executing statement: " . htmlspecialchars($stmt->error)); //If theres something wrong with binding the param ID, throws error and dies.
}
$result = $stmt->get_result();
if(!$result) {
    die("Error getting results: " . htmlspecialchars($conn->error)); //If there isn't a result to show, throws an error and dies.
}
$adminInfo = $result->fetch_assoc();

$isSuperUser = isset($adminInfo['SuperUser']) && $adminInfo['SuperUser'] == 1;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin info</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/styleadmininfo.css">
    <script src="scripts/jsscriptadmininfo.js"></script>
    <link rel="icon" href="img/lasalle.ico" type="image/ico">

    <!-- Checks if the user that requested certain admin info is Super User. If true, shows the edit and delete button. There's a vulnerability here which if someone isn't Super User and manages to access via URL to delete and edit functions while logged in, will allow them to edit and delete, even if thet aren't Super User. -->
    <?php if (!$_SESSION['SuperUser']): ?>
        <style>
            #buttoneditadminphp, #buttondeleteadminphp {
                display: none;
            }
        </style>
    <?php endif; ?>

    <style>
        <?php if (!$_SESSION['SuperUser']): ?>
            #buttoneditadminphp, #buttondeleteadminphp {
                display: none;
            }
        <?php endif; ?>
    </style>
</head>
<body>
    <div class="container mt-5 custom-background">
        <br><br><h2 class="text-center mb-4">Universidad La Salle</h2>
        <h2 class="text-center mb-4">Teachers file</h2><br>
    </div>
    
    <br>
    
    <div class="text-center">

    <div class="d-flex justify-content-center">
        <form id="buttondeleteadminphp" action="php/deleteadmin.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this admin?');" class="mr-2">
            <input type="hidden" name="ID" value="<?php echo htmlspecialchars($adminInfo['ID']); ?>"> <!-- When deleting, sends via Session the ID of the selected admin for its deletion -->
            <input type="submit" id="deleteadmin" value="Delete Admin" class="btn btn-danger">
        </form>

        <input type="button" id="gobacktoindex" value="Return to Index" class="btn btn-success mr-2" onclick="OpenIndex()">

        <form id="buttoneditadminphp" action="editadmin.php" method="GET">
            <input type="hidden" name="ID" value="<?php echo htmlspecialchars($adminInfo['ID']); ?>"> <!-- Same thing here, we send ID via session to edit the selected Admin -->
            <input type="submit" id="editadmin" value="Edit Admin" class="btn btn-primary">
        </form>

    </div>

    <br>
    <div class="text-center">
        <h1 class="mb-0">Admin Info</h1>
    </div>
    <br>

    <!-- Even here whe use a 3 column shrinkable auto-adjustable desieng depending on window size -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 text-center">
                <!-- Column 1: Photo -->
                <?php if (!empty($adminInfo['Photo'])): ?>
                    <img src="php/getadminimage.php?ID=<?php echo $adminInfo['ID']; ?>" alt="Admin Photo" class="img-fluid">
                <?php endif; ?>
            </div>

            <!-- Column 2: Personal Data -->
            <div class="col-md-4">
                <h3>Personal Data</h3>
                <p>Fullname: <?php echo htmlspecialchars($adminInfo['FirstName']) . " " . htmlspecialchars($adminInfo['FirstSurname']) . " " . htmlspecialchars($adminInfo['SecondSurname']); ?></p>
                <p>Birthday: <?php echo htmlspecialchars($adminInfo['Birthday']); ?></p>
                <p><?php echo htmlspecialchars($adminInfo['Age']); ?> Years Old</p>
                <p>Sex: <?php echo htmlspecialchars($adminInfo['Sex']); ?></p>
            </div>

            <!-- Column 3: Account Info -->
            <div class="col-md-4">
                <h3>Account Info</h3>
                <p>Email: <?php echo htmlspecialchars($adminInfo['Email']); ?></p>
                <p>Password: <?php echo htmlspecialchars($adminInfo['Password']); ?></p>
                <p>Unique KeyID: <?php echo htmlspecialchars($adminInfo['ID']); ?></p>
                <?php if ($isSuperUser): ?>
                    <p>Admin Has Super User Access.</p>
                <?php else: ?>
                    <p>Admin Doesn't Have Super User Access.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>