<?php
// process_subject.php - Handle subject form submissions

// Add your server-side processing logic here
// For example, you can access form data using $_POST

$servername = "your_server_name";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from POST
$deptId = $_POST['deptId'];
$semester = $_POST['semester'];
$section = $_POST['section'];
$subjectName = $_POST['subjectName'];
$elective = $_POST['elective'];
$teacher = $_POST['teacher'];

// SQL query to insert data into the database
$sql = "INSERT INTO subjects (DeptId, Semester, Section, SubName, Elective, Tid)
        VALUES ('$deptId', '$semester', '$section', '$subjectName', '$elective', '$teacher')";

if ($conn->query($sql) === TRUE) {
    echo "Record added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();

// Redirect back to the form or another page after processing
header("Location: subject.html");
exit();
?>
