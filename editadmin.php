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

$ID = $_GET['ID'] ?? '';

//Gets the admin data via ID in Session
$stmt = $conn->prepare("SELECT * FROM Admins WHERE ID = ?");
$stmt->bind_param("s", $ID);
$stmt->execute();
$result = $stmt->get_result();
$adminInfo = $result->fetch_assoc();

$isSuperUser = isset($adminInfo['SuperUser']) && $adminInfo['SuperUser'] == 1 ? true : false;

?>

<!DOCTYPE html>
    <html lang="en">
        <head>
            <title>Edit Admin</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="style/styleeditadmin.css">
            <script src="scripts/jsscripteditadmin.js"></script>
            <link rel="icon" href="img/lasalle.ico" type="image/ico">
            <script>
                //Just like any other form in this project, we limit input in number fields inside forms.
                function LimitInputNumber9(event) {
                    var number = event.target.value;
                    number = number.toString();
                    if (number.length > 9) {
                    number = number.slice(0, 9);
                    }
                    event.target.value = number;
                }   
                function LimitInputNumber2(event) {
                    var number = event.target.value;
                    number = number.toString();
                    if (number.length > 2) {
                    number = number.slice(0, 2);
                    }
                    event.target.value = number;
                }
                //Shows a preview of the uploaded Picture.
                function showPreview(event) {
                    if (event.target.files.length > 0) {
                        var src = URL.createObjectURL(event.target.files[0]);
                        var preview = document.getElementById("photo-preview");
                        preview.src = src;
                        preview.style.display = "block";
                    }
                }  
            </script>
            <!-- Allows Super Users to enable Super User status on other admins but only if editor is Super User -->
            <?php if (!$_SESSION['SuperUser']): ?> 
                <style>
                    #formsuperuseroption {
                        display: none;
                    }
                </style>
            <?php endif; ?>
        </head>
    <body>       
        
        <div class="container mt-5 custom-background">
            <br><br><h2 class="text-center mb-4">Universidad La Salle</h2>
            <h2 class="text-center mb-4">Teachers file</h2><br>
        </div>

        <div id="ReturnToIndex" class="row justify-content-center">
            <div class="mb-4">
                <br>
                <a href="index.php" class="btn btn-primary">Return to Index</a>
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <form id="formeditadmin" action="php/updateadmin.php" target="_self" method="POST" enctype="multipart/form-data">
                        <div class="row"> <!-- Just like any other form, 3 columns for shrinkable auto-adjustable depdending on window size. -->
                            <!-- Column 1: Personal Data -->
                            <div class="col-md-4">
                                <h3>Personal Data</h3>
                                <div id="photo">
                                    <label for="photo">Profile Picture</label>
                                    <br>
                                    <input type="file" name="photo" accept="image/jpeg" required onchange="showPreview(event);">
                                    <p style="font-style: italic;">*Only JPEG and JPG files are admitted. File size must be less than 200MBs.</p>
                                    <div class="preview-container" style="margin-top: 10px;">
                                        <img id="photo-preview" src="#" alt="Profile Image Preview" style="display: none; width: 100%; max-width: 300px; height: auto;">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="firstname">Name</label><br>
                                    <input type="text" id="firstname" name="FirstName" class="form-control" placeholder="John..." value="<?php echo htmlspecialchars($adminInfo['FirstName'] ?? ''); ?>" maxlength="19" required>
                                </div>
                                <div class="mb-4">
                                    <label for="FistSurname">First Surname</label><br>
                                    <input type="text" id="firstsurname" name="FirstSurname" class="form-control" placeholder="Appleseed..." value="<?php echo htmlspecialchars($adminInfo['FirstSurname'] ?? ''); ?>" maxlength="19" required>
                                </div>
            
                                <div class="mb-4">
                                    <label for="SecondSurname">Second Surname</label><br>
                                    <input type="text" id="secondsurname" name="SecondSurname" class="form-control" placeholder="Kennedy..." value="<?php echo htmlspecialchars($adminInfo['SecondSurname'] ?? ''); ?>" maxlength="19" required>
                                </div>
                            </div>

                            <!-- Column 2: More info -->
                            <div class="col-md-4">
                                <h3>Birthday</h3>
                                <div class="mb-4">
                                    <label for="birthday">Select your birthday</label><br>
                                    <input type="date" id="birthday" name="Birthday" value="<?php echo htmlspecialchars($adminInfo['Birthday'] ?? ''); ?>" class="form-control" required>
                                </div>
            
                                <div class="mb-4">
                                    <label for="age">Age</label><br>
                                    <input type="number" id="age" name="Age" class="form-control" placeholder="23..." value="<?php echo htmlspecialchars($adminInfo['Age'] ?? ''); ?>" oninput="LimitInputNumber2(event)" required>
                                </div>
            
                                <div id="Sex" class="mb-4">
                                    <h3>Sex</h3>
                                    <label for="Sex">Select One</label><br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Sex" value="Male" id="male" <?php echo (isset($adminInfo['Sex']) && $adminInfo['Sex'] === 'Male') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Sex" value="Female" id="female" <?php echo (isset($adminInfo['Sex']) && $adminInfo['Sex'] === 'Female') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 3: Account Info -->
                            <div class="col-md-4">
                                <h3>Account Info</h3>
                                <div class="mb-4">
                                    <label for="email">Email</label><br>
                                    <input type="email" id="email" name="Email" class="form-control" placeholder="johnappleseed@icloud.com" value="<?php echo htmlspecialchars($adminInfo['Email'] ?? ''); ?>" maxlength="49" required>
                                </div>

                                <div class="mb-4">
                                    <label for="password">Password</label><br>
                                    <input type="password" id="password" name="Password" class="form-control" placeholder="Abc.123#$" value="<?php echo htmlspecialchars($adminInfo['Password'] ?? ''); ?>" maxlength="49" required>
                                </div>
                                <h3>Super User Status</h3>
                                <div id="formsuperuseroption" class="mb-4">
                                    <label for="superuser">Select The Admin's Super User status</label><br>
                                    <input type="checkbox" id="superuser" name="SuperUser" value="1">
                                    <label for="superuser">Super User</label><br>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div id="SubmitButtonTeachers" class="mb-4">
                                    <div class="d-flex justify-content-center">
                                        <input type="submit" id="submitbtnregisternewteacher" value="Submit Changes" class="btn btn-success">
                                    </div>
                                </div>
                                <div id="ResetButton" class="mb-4">
                                    <div class="d-flex justify-content-center">
                                        <input type="reset" value="Reset Form" class="btn btn-danger" onclick="ResetForm()">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>