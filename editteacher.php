<!-- All Edit forms include the real user info, filling in all the fields with the User real info. -->
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

$ID = $_GET['ID'] ?? ''; //Gets Teacher ID from Session via GET

//Queries for retreiving all the teacher info so that the form is filled with thea teacher info.
$stmt = $conn->prepare("SELECT * FROM Teacher WHERE ID = ?");
$stmt->bind_param("s", $ID);
$stmt->execute();
$result = $stmt->get_result();
$teacherInfo = $result->fetch_assoc();

$sqlClasses = "SELECT ClassroomNumber FROM Classes";
$resultClasses = $conn->query($sqlClasses);
$allClasses = [];
while ($row = $resultClasses->fetch_assoc()) {
    $allClasses[] = $row['ClassroomNumber'];
}

$sqlAssignments = "SELECT AssignmentName FROM Assignments";
$resultAssignments = $conn->query($sqlAssignments);
$allAssignments = [];
while ($row = $resultAssignments->fetch_assoc()) {
    $allAssignments[] = $row['AssignmentName'];
}

$sqlShifts = "SELECT ShiftField FROM Shift";
$resultShifts = $conn->query($sqlShifts);
$allShifts = [];
while ($row = $resultShifts->fetch_assoc()) {
    $allShifts[] = $row['ShiftField'];
}

//Since Classes, Assignments and Shifts are JSON, we most decode them for its use.
$classes = json_decode($teacherInfo['Classes'] ?? '[]', true);
$assignments = json_decode($teacherInfo['Assignments'] ?? '[]', true);
$shifts = json_decode($teacherInfo['Shift'] ?? '[]', true);

?>
<!DOCTYPE html>
    <html lang="en">
        <head>
            <title>Edit Teacher</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="style/styleeditteacher.css">
            <script src="scripts/jsscripteditteacher.js"></script>
            <link rel="icon" href="img/lasalle.ico" type="image/ico">
            <script>
                //js Functions to limimt number inputs for certain fields, since html doesn't have a limit for numbers, Only Text fields.
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
                //Shows the photo preview.
                function showPreview(event) {
                    if (event.target.files.length > 0) {
                        var src = URL.createObjectURL(event.target.files[0]);
                        var preview = document.getElementById("photo-preview");
                        preview.src = src;
                        preview.style.display = "block";
                    }
                }
                //Resets the form, including the photo preview
                function ResetForm() {
                    document.getElementById("formeditteacher").reset();
                    var preview = document.getElementById("photo-preview");
                    preview.src = "";
                    preview.style.display = "none";
                    document.getElementById("firstname").focus();
                }
            </script>
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
                    <form id="formeditteacher" action="php/updateteacher.php" method="POST" enctype="multipart/form-data">
                        <div id="hideShowContainer" class="row"> <!-- To keep things neat, organized and functional, I decided to use a triple column srhinkable and adjustable with the window aspect ratio design.-->
                            <!-- Column 1: Personal Data -->
                            <div class="col-md-4">
                                <h3>Personal Data</h3>
                                <div id="photo">
                                    <label for="photo">Profile Picture</label>
                                    <br>
                                    <input type="file" name="photo" accept="image/jpeg" required onchange="showPreview(event);">
                                    <p style="font-style: italic;">*Only JPEG and JPG files are admitted. File size must be less than 200MBs.</p>
                                    <!-- Container for image preview -->
                                    <div class="preview-container" style="margin-top: 10px;">
                                        <img id="photo-preview" src="#" alt="Profile Image Preview" style="display: none; width: 100%; max-width: 300px; height: auto;">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="firstname">Name</label><br>
                                    <input type="text" id="firstname" name="FirstName" class="form-control" placeholder="John..." value="<?php echo htmlspecialchars($teacherInfo['FirstName'] ?? ''); ?>" maxlength="19" required>
                                </div>
                                <div class="mb-4">
                                    <label for="FistSurname">First Surname</label><br>
                                    <input type="text" id="firstsurname" name="FirstSurname" class="form-control" placeholder="Appleseed..." value="<?php echo htmlspecialchars($teacherInfo['FirstSurname'] ?? ''); ?>" maxlength="19" required>
                                </div>
            
                                <div class="mb-4">
                                    <label for="SecondSurname">Second Surname</label><br>
                                    <input type="text" id="secondsurname" name="SecondSurname" class="form-control" placeholder="Kennedy..." value="<?php echo htmlspecialchars($teacherInfo['SecondSurname'] ?? ''); ?>" maxlength="19" required>
                                </div>
            
                                <div class="mb-4">
                                    <label for="birthday">Select your birthday</label><br>
                                    <input type="date" id="birthday" name="Birthday" value="<?php echo htmlspecialchars($teacherInfo['Birthday'] ?? ''); ?>" class="form-control" required>
                                </div>
            
                                <div class="mb-4">
                                    <label for="age">Age</label><br>
                                    <input type="number" id="age" name="Age" class="form-control" placeholder="23..." value="<?php echo htmlspecialchars($teacherInfo['Age'] ?? ''); ?>" oninput="LimitInputNumber2(event)" required>
                                </div>

                                <div class="mb-4">
                                    <label for="career">Career</label><br>
                                    <input type="text" id="career" name="Career" class="form-control" placeholder="Engineer..." value="<?php echo htmlspecialchars($teacherInfo['Career'] ?? ''); ?>" maxlength="49" required>
                                </div>

                                <div class="mb-4">
                                    <label for="adress">Adress</label><br>
                                    <input type="text" id="adress" name="Adress" class="form-control" placeholder="1 Infinite Loop Cupertino, CA 95014..." value="<?php echo htmlspecialchars($teacherInfo['Adress'] ?? ''); ?>" maxlength="99" required>
                                </div>

                                <div class="mb-4">
                                    <label for="phonenumber">Phone Number</label><br>
                                    <input type="number" id="phonenumber" name="PhoneNumber" class="form-control" placeholder="+52 (55) 9999 9999..." value="<?php echo htmlspecialchars($teacherInfo['PhoneNumber'] ?? ''); ?>" oninput="LimitInputNumber9(event)" required>
                                </div>
                            </div>

                            <!-- Column 2: Account and more Teacher Info -->
                            <div class="col-md-4">
                                <h3>Sex</h3>
                                <div id="Sex" class="mb-4">
                                    <label for="Sex">Select One</label><br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Sex" value="Male" id="male" <?php echo (isset($teacherInfo['Sex']) && $teacherInfo['Sex'] === 'Male') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Sex" value="Female" id="female" <?php echo (isset($teacherInfo['Sex']) && $teacherInfo['Sex'] === 'Female') ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>
                                </div>
                                <div id="maritalStatus" class="mb-4">
                                    <h3>Marital Status</h3>
                                    <label for="MaritalStatus">Select Marital Status</label><br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="MaritalStatus" value="Married" id="married" <?php echo ($teacherInfo['MaritalStatus'] ?? '') === 'Married' ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="married">Married</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="MaritalStatus" value="Widowed" id="widowed" <?php echo ($teacherInfo['MaritalStatus'] ?? '') === 'Widowed' ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="widowed">Widow</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="MaritalStatus" value="Single" id="single" <?php echo ($teacherInfo['MaritalStatus'] ?? '') === 'Single' ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="single">Single</label>
                                    </div>
                                </div>

                                <div id = "accountinfo">
                                    <h3>Account Info</h3>
                                    <div class="mb-4">
                                        <label for="email">Email</label><br>
                                        <input type="email" id="email" name="Email" class="form-control" placeholder="johnappleseed@icloud.com" value="<?php echo htmlspecialchars($teacherInfo['Email'] ?? ''); ?>" maxlength="49" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password">Password</label><br>
                                        <input type="password" id="password" name="Password" class="form-control" placeholder="Abc.123#$" value="<?php echo htmlspecialchars($teacherInfo['Password'] ?? ''); ?>" maxlength="49" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 3: Marital Status and Other Info -->
                            <div class="col-md-4">
                            <div id = "teacherinfo">
                                <h3>Teacher Info</h3>

                                <div class="mb-4">
                                    <label for="classes">Enroll Classrooms</label><br>
                                    <?php foreach ($allClasses as $class): ?>
                                        <input type="checkbox" id="class_<?= htmlspecialchars($class) ?>" name="ClassroomNumbers[]" value="<?= htmlspecialchars($class) ?>" <?= in_array($class, $classes) ? 'checked' : '' ?>>
                                        <label for="class_<?= htmlspecialchars($class) ?>"><?= htmlspecialchars($class) ?></label><br>
                                    <?php endforeach; ?>
                                </div>

                                <div class="mb-4">
                                    <label for="assignments">Enroll Assignments</label><br>
                                    <?php foreach ($allAssignments as $assignment): ?>
                                        <input type="checkbox" id="assignment_<?= htmlspecialchars($assignment) ?>" name="AssignmentName[]" value="<?= htmlspecialchars($assignment) ?>" <?= in_array($assignment, $assignments) ? 'checked' : '' ?>>
                                        <label for="assignment_<?= htmlspecialchars($assignment) ?>"><?= htmlspecialchars($assignment) ?></label><br>
                                    <?php endforeach; ?>
                                </div>


                                <div class="mb-4">
                                    <label for="shift">Select The Teacher's Shift</label><br>
                                    <?php foreach ($allShifts as $shift): ?>
                                        <input type="checkbox" id="shift_<?= htmlspecialchars($shift) ?>" name="ShiftField[]" value="<?= htmlspecialchars($shift) ?>" <?= in_array($shift, $shifts) ? 'checked' : '' ?>>
                                        <label for="shift_<?= htmlspecialchars($shift) ?>"><?= htmlspecialchars($shift) ?></label><br>
                                    <?php endforeach; ?>
                                </div>
                                <input type="hidden" name="ID" value="<?php echo htmlspecialchars($ID); ?>">
                            </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <div class="d-flex justify-content-center">
                                        <input type="submit" value="Submit Changes" class="btn btn-success">
                                    </div>
                                </div>
                                <div class="mb-4">
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
        <script>
            function ResetForm() {
            document.getElementById("formeditteacher").reset();
            var preview = document.getElementById("photo-preview");
            preview.src = "";
            preview.style.display = "none";
            document.getElementById("firstname").focus();
        }
        </script>
    </body>
</html>