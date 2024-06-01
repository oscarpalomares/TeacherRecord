<?php
//Debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); 

if (!isset($_SESSION['FirstName'])) {
    header("Location: /loggin.html");
    exit();
}

//Passes session variables.
$FirstName = $_SESSION['FirstName'];
$SuperUser = $_SESSION['SuperUser'];


$host = 'localhost';
$dbname = 'FinalProject';
$username = 'usuario2024';
$password = 'usuario2024';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Queries for the required data.
$sqlClass = "SELECT ClassroomNumber FROM Classes";
$resultClass = $conn->query($sqlClass);

$sqlAssignments = "SELECT AssignmentName FROM Assignments";
$resultAssignments = $conn->query($sqlAssignments);

$sqlShift = "SELECT ShiftField FROM Shift";
$resultShift = $conn->query($sqlShift);


?>

<!DOCTYPE html>
    <html lang="en">
        <head>
            <title>Register</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="style/styleregisternewteacher.css">
            <script src="scripts/jsscriptregisternewteacher.js"></script>
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
                    <form id="formregisternewteacher" action="php/registernewteacher.php" method="POST" enctype="multipart/form-data">
                        <h1 class="text-center">Register a new Teacher</h1>
                        <div class="row" id = "hideShowContainer">
                            <div class="col-md-4"> <!-- Just like any other form, I splitted every form into 3 columns to make things autoadjustable depending on window size. -->
                                <!-- Column 1: Personal Data -->
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
                                <input type="text" id="firstname" name="FirstName" class="form-control" placeholder="John..." maxlength="19" required>
                            </div>
                            <div class="mb-4">
                                <label for="FistSurname">First Surname</label><br>
                                <input type="text" id="firstsurname" name="FirstSurname" class="form-control" placeholder="Appleseed..." maxlength="19" required>
                            </div>
        
                            <div class="mb-4">
                                <label for="SecondSurname">Second Surname</label><br>
                                <input type="text" id="secondsurname" name="SecondSurname" class="form-control" placeholder="Kennedy..." maxlength="19" required>
                            </div>
        
                            <div class="mb-4">
                                <label for="birthday">Select your birthday</label><br>
                                <input type="date" id="birthday" name="Birthday" class="form-control" required>
                            </div>
        
                            <div class="mb-4">
                                <label for="age">Age</label><br>
                                <input type="number" id="age" name="Age" class="form-control" placeholder="23..." oninput="LimitInputNumber2(event)" required>
                            </div>

                            <div class="mb-4">
                                <label for="career">Career</label><br>
                                <input type="text" id="career" name="Career" class="form-control" placeholder="Engineer..." maxlength="49" required>
                            </div>

                            <div class="mb-4">
                                <label for="adress">Adress</label><br>
                                <input type="text" id="adress" name="Adress" class="form-control" placeholder="1 Infinite Loop Cupertino, CA 95014..." maxlength="99" required>
                            </div>

                            <div class="mb-4">
                                <label for="phonenumber">Phone Number</label><br>
                                <input type="number" id="phonenumber" name="PhoneNumber" class="form-control" placeholder="+52 (55) 9999 9999..." oninput="LimitInputNumber9(event)" required>
                            </div>
                        </div>

                            <!-- Column 2: More Teacher Info-->
                        <div class="col-md-4">
                            <div id = "Sex" class = "mb-4">
                                <h3>Sex</h3>
                                <label for ="Sex">Select One</label><br>
                                <div class = "form-check">
                                    <input class="form-check-input" type="radio" name="Sex" value="Male" id="male" required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class = "form-check">
                                    <input class="form-check-input" type="radio" name="Sex" value="Female" id="female" required>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>

                            <div id = "maritalStatus" class = "mb-4">
                                <h3>Marital Status</h3>
                                <label for = "MaritalStatus">Select Marital Status</label><br>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="MaritalStatus" value="Married" id="married" required>
                                    <label class="form-check-label" for="married">Married</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="MaritalStatus" value="Widowed" id="widowed" required>
                                    <label class="form-check-label" for="widowed">Widow</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="MaritalStatus" value="Single" id="single" required>
                                    <label class="form-check-label" for="single">Single</label>
                                
                            </div>
                        </div>
                        <h3>Teacher Info</h3>
                        <div class="mb-4" id="classesDIV">
                            <label for="classes">Enroll Classrooms</label><br>
                            <?php
                            if ($resultClass->num_rows > 0) {
                                while($row = $resultClass->fetch_assoc()) {
                                    echo '<div class="form-check">';
                                    echo '<input class="form-check-input" type="checkbox" name="ClassroomNumbers[]" value="' . $row["ClassroomNumber"] . '" id="class_' . $row["ClassroomNumber"] . '">';
                                    echo '<label class="form-check-label" for="class_' . $row["ClassroomNumber"] . '">Classroom ' . $row["ClassroomNumber"] . '</label>';
                                    echo '</div>';
                                }
                            } else {
                                echo "No classrooms found";
                            }
                            ?>
                        </div>

                        <div class = "mb-4" id="assignmentsDIV">
                            <label for = "Assignments">Enroll Assignments</label>
                            <?php
                                if ($resultAssignments->num_rows > 0) {
                                    while($row = $resultAssignments->fetch_assoc()) {
                                        echo '<div class="form-check">';
                                        echo '<input class="form-check-input" type="checkbox" name="AssignmentName[]" value="' . $row["AssignmentName"] . '" id="class_' . $row["AssignmentName"] . '">';
                                        echo '<label class="form-check-label" for="class_' . $row["AssignmentName"] . '"> ' . $row["AssignmentName"] . '</label>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo "No Assignments Found";
                                }
                            ?>
                        </div>

                            <div class="mb-4" id = "shiftDIV">
                                <label for="shift">Select The Teacher's Shift</label><br>
                                <?php
                                    if ($resultShift->num_rows > 0) {
                                        while($row = $resultShift->fetch_assoc()) {
                                            echo '<div class="form-check">';
                                            echo '<input class="form-check-input" type="checkbox" name="ShiftField[]" value="' . $row["ShiftField"] . '" id="class_' . $row["ShiftField"] . '">';
                                            echo '<label class="form-check-label" for="class_' . $row["ShiftField"] . '"> ' . $row["ShiftField"] . '</label>';
                                            echo '</div>';
                                        }
                                    } else {
                                        echo "No Assignments Found";
                                    }
                                ?>   
                            </div>  
                        </div>

                            <!-- Column 3: Account Info -->
                            <div class="col-md-4">
                                <h3>Account Info</h3>
                                <div class="mb-4">
                                            <label for="email">Email</label><br>
                                            <input type="email" id="email" name="Email" class="form-control" placeholder="johnappleseed@icloud.com" maxlength="49" required>
                                        </div>
    
                                        <div class="mb-4">
                                            <label for="password">Password</label><br>
                                            <input type="password" id="password" name="Password" class="form-control" placeholder="Abc.123#$" maxlength="49" required>
                                        </div>

                                        <div id = "keyid" class = "mb-4">
                                            <label for = "keyid">Type In a Unique Key ID</label><br>
                                            <input type="text" id="keyid" name="ID" class="form-control" placeholder="123aBc$..." maxlength="9" required>
                                        </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div id="SubmitButtonTeachers" class="mb-4">
                                    <div class="d-flex justify-content-center">
                                        <input type="submit" id="submitbtnregisternewteacher" value="Register Teacher" class="btn btn-success">
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