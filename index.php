<?php
//Just some debugging "tools" to help me identify errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_set_cookie_params(0);
session_start(); 

//Wets the time session (cookies)
setcookie(session_name(), session_id(), time() + 1800); //Can be glitched, could use more work to make it more secure.

//Checks if the session is still on, if it isn't, returns you to loggin.
if (!isset($_SESSION['FirstName'])) {
    header("Location: http://localhost/Projects/PF/loggin.html");
    exit();
}

//Passes variables for session and data handling in future transactions.
$FirstName = $_SESSION['FirstName'];
$SuperUser = $_SESSION['SuperUser'];

//Database connection credentials.
$host = 'localhost';
$dbname = 'FinalProject';
$username = 'usuario2024';
$password = 'usuario2024';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//This whole section retrieves all the specified info from Teacher, Admins, Classes and Assignments.
$sql = "SELECT FirstName, FirstSurname, SecondSurname, Career, ID FROM Teacher";
$result = $conn->query($sql);

$sqlAdmins = "SELECT FirstName, FirstSurname, SecondSurname, Email, ID FROM Admins";
$resultAdmins = $conn->query($sqlAdmins);

$sqlClassrooms = "SELECT ID, ClassroomNumber FROM Classes";
$resultClassrooms = $conn ->query($sqlClassrooms);

$sqlAssignments = "SELECT ID, AssignmentName FROM Assignments";
$resultAssignments = $conn -> query($sqlAssignments);

?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Index</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="style/styleindex.css">
        <link rel="icon" href="img/lasalle.ico" type="image/ico">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="scripts/jsscriptindex.js"></script>
        <script>
            //Searching in every tab, using jQuery, filters the inserted text with the table context. Passes it into lowercase to avoid errors.
            //Search for Teacher tab
            $(document).ready(function(){
            $("#searchButtonTeacher").click(function(){
                var value = $("#searchInputTeacher").val().toLowerCase();
                $("#teacherTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            //Search for Admin tab
            $("#searchButtonAdmin").click(function(){
                var value = $("#searchInputAdmin").val().toLowerCase();
                $("#adminTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            //Search for Classroom tab
            $("#searchButtonClassroom").click(function(){
                var value = $("#searchInputClassroom").val().toLowerCase();
                $("#classroomTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            //Search for Assignments tab
            $("#searchButtonAssignment").click(function(){
                var value = $("#searchInputAssignment").val().toLowerCase();
                $("#assignmentTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
        </script>
    </head>
    <!-- Navbar for the web page with tabs, using Angular. -->
    <body ng-app="myApp" ng-controller="TabController">
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav" id="globalnav">
                    <li class="nav-item">
                        <a class="nav-link" href="#" ng-click="changeTab('TeacherRecord')">Teacher Record</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" ng-click="changeTab('AdminRecord')">Admin Record</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" ng-click="changeTab('ClassroomRecord')">Classroom Record</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" ng-click="changeTab('AssignmentsRecord')">Assignments Record</a>
                    </li>
                </ul>
            </div>
        </nav>       
        <br>
        <br>
        <div class="custom-background">
            <br><br><h2 class="text-center mb-4">Universidad La Salle</h2>
            <h2 class="text-center mb-4">Teachers file</h2><br>
        </div>

        <br>
        <div class="col-md-8 d-flex align-items-center">
            <h1 class="mb-0">Welcome, <?php echo htmlspecialchars($FirstName); ?>!</h1>
            <a href="php/logout.php" class="ml-2">log out</a>
            <br>
        </div>

        <!-- Checks if the logged in user is SuperUser, if true, gives permission to edit and delete other admins. Also shows info "You are Super User" -->
        <?php if ($SuperUser): ?>
                <div class="row">
                    <div class="col-md-8">
                        <p class="col-md-8">You are Super User.</p>
                    </div>
                </div>
        <?php endif; ?>

        <!-- Teacher Record tab, we are using Angular for the Navbar -> Tab technology. -->
        <div id="TeacherRecord" ng-show="currentTab === 'TeacherRecord'">
            <h1 class="text-center mb-4">Teacher Record</h1>
            <div id="searchContainerTeacher" class="text-center mb-4">
                <input type="text" id="searchInputTeacher" placeholder="Search Teacher...">
                <button id="searchButtonTeacher">Search</button>
            </div>
            <?php
            //Conditional Table Content. If found, shows the specified information.
            if ($result->num_rows > 0) {
                echo '<table id = "teacherTable" class="table table-striped">';
                echo '<thead><tr><th>First Name</th><th>First Surname</th><th>Second Surname</th><th>Career</th><th></th></tr></thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['FirstName']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['FirstSurname']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['SecondSurname']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Career']) . '</td>';
                    
                    $ID = $row['ID'];
                    
                    echo '<td><a href="teacherdetails.php?ID=' . $ID . '" class="btn btn-primary" target="teacherdetails.php">Open Details</a></td>';
                    
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } 
            else 
                echo "No records found";
            ?>

            <div id="AddNewTeacherDiv" class="row justify-content-end">
                <div class="mb-4" style="margin-right: 50px;">
                    <a href="registernewteacher.php" class="btn btn-success" target = "registernewteacher.php">Add New Teacher</a>
                </div>
            </div>
        </div>

        <!-- Admin Record tab, we are using Angular for the Navbar -> Tab technology. -->
        <div id="AdminRecord" ng-show="currentTab === 'AdminRecord'">
            <h1 class="text-center mb-4">Admin Record</h1>
            <div id="searchContainerAdmin" class="text-center mb-4">
                <input type="text" id="searchInputAdmin" placeholder="Search Admin...">
                <button id="searchButtonAdmin">Search</button>
            </div>
            <?php
                //Conditional Table Content. If found, shows the specified information.
                if ($resultAdmins->num_rows > 0) {
                    echo '<table id = "adminTable" class="table table-striped">';
                    echo '<thead><tr><th>First Name</th><th>First Surname</th><th>Second Surname</th><th>Email</th><th></th></tr></thead>';
                    echo '<tbody>';
                    while ($rowAdmin = $resultAdmins->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($rowAdmin['FirstName']) . '</td>';
                        echo '<td>' . htmlspecialchars($rowAdmin['FirstSurname']) . '</td>';
                        echo '<td>' . htmlspecialchars($rowAdmin['SecondSurname']) . '</td>';
                        echo '<td>' . htmlspecialchars($rowAdmin['Email']) . '</td>';
                        
                        $ID = $rowAdmin['ID'];
                
                        // If you dont want the page to be opened in a new tab, use this: echo '<td><a href="admindetails.php?AdminID=' . $AdminID . '" class="btn btn-primary">Open Details</a></td>';
                        echo '<td><a href="admindetails.php?ID=' . $ID . '" class="btn btn-primary" target = "admindetails.php">Open Details</a></td>';
                        
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                } 
                else
                    echo "No admin records found";
            ?>
            <div id="AddNewAdminDiv" class="row justify-content-end">
                <div class="mb-4" style="margin-right: 50px;">
                    <a href="registernewadmin.html" class="btn btn-success" target = "registernewadmin.html">Add New Admin</a>
                </div>
            </div>
        </div>

        <!-- Classroom Record tab, we are using Angular for the Navbar -> Tab technology. -->
        <div id="ClassroomRecord" ng-show="currentTab === 'ClassroomRecord'">
            <h1 class="text-center mb-4">Classroom Record</h1>
            <div id="searchContainerClassroom" class="text-center mb-4">
                <input type="text" id="searchInputClassroom" placeholder="Search Classroom...">
                <button id="searchButtonClassroom">Search</button>
            </div>
            <?php
                //Conditional Table Content. If found, shows the specified information.
                if ($resultClassrooms->num_rows > 0) {
                    echo '<div class="container mt-4">';
                    echo '<div class="row">';
                    echo '<div class="col-md-12 d-flex justify-content-center">';
                    echo '<table id = "classroomTable" class="table table-striped">';
                    echo '<thead><tr><th>ID</th><th>Classroom Number</th><th class="text-right"></th></tr></thead>';
                    echo '<tbody>';
                    while ($rowClassrooms = $resultClassrooms->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($rowClassrooms['ID']) . '</td>';
                        echo '<td>' . htmlspecialchars($rowClassrooms['ClassroomNumber']) . '</td>';

                        $ID = $rowClassrooms['ID'];

                        echo '<td class="text-right"><a href="php/deleteclassroom.php?ClassroomNumber=' . urlencode($rowClassrooms['ClassroomNumber']) . '" class="btn btn-danger" target="_self">Delete Classroom</a></td>';
                        
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>'; 
                    echo '</div>'; 
                    echo '</div>'; 
                } else {
                    echo "No Classroom record found";
                }
            ?>

            <div id="AddNewClassroomDiv" class="row justify-content-end">
                <div class="mb-4" style="margin-right: 50px;">
                    <a href="registernewclassroom.html" class="btn btn-success" target = "registernewclassroom.html">Add New Classroom</a>
                </div>
            </div>
        </div>

        <!-- Assignments Record tab, we are using Angular for the Navbar -> Tab technology. -->
        <div id = "AssignmentsRecord" ng-show="currentTab === 'AssignmentsRecord'">
            <h1 class="text-center mb-4">Assignments Record</h1>
            <div id="searchContainerassignment" class="text-center mb-4">
                <input type="text" id="searchInputAssignment" placeholder="Search Assignment...">
                <button id="searchButtonAssignment">Search</button>
            </div>
            <?php
                //Conditional Table Content. If found, shows the specified information.
                if ($resultAssignments->num_rows >0) {
                    echo '<div class="container mt-4">';
                    echo '<div class="row">';
                    echo '<div class="col-md-12 d-flex justify-content-center">';
                    echo '<table id = "assignmentTable" class="table table-striped">';
                    echo '<thead><tr><th>ID</th><th>Assignment Name</th><th class="text-right"></th></tr></thead>';
                    echo '<tbody>';
                    while ($rowAssignments = $resultAssignments->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($rowAssignments['ID']) . '</td>';
                        echo '<td>' . htmlspecialchars($rowAssignments['AssignmentName']) . '</td>';

                        $ID = $rowAssignments['ID'];

                        echo '<td class="text-right"><a href="php/deleteassignment.php?AssignmentName=' . urlencode($rowAssignments['AssignmentName']) . '" class="btn btn-danger" target="_self">Delete Assignment</a></td>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>'; 
                    echo '</div>'; 
                    echo '</div>'; 

                } 
                else
                    echo "No Assignment record found";
            ?>

            <div id="AddNewAssignmentDiv" class="row justify-content-end">
                <div class="mb-4" style="margin-right: 50px;">
                    <a href="registernewassignment.html" class="btn btn-success" target = "registernewassignment.html">Add New Assignment</a>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
        <script src="scripts/jsscriptindex.js"></script>
    </body>
</html>
