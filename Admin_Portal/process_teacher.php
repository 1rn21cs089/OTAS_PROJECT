<?php
// process_teacher.php - Handle teacher form submissions

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
$teacherId = $_POST['teacherId'];
$teacherFirstName = $_POST['teacherFirstName'];
$teacherLastName = $_POST['teacherLastName'];
$department = $_POST['department'];
$designation = $_POST['designation'];
$teacherEmail = $_POST['teacherEmail'];
$teacherPassword = $_POST['teacherPassword'];

// SQL query to insert data into the database
$sql = "INSERT INTO teacher (Tid, Teacher_FName, Teacher_LName, DeptId, Designation, Email, Password)
        VALUES ('$teacherId', '$teacherFirstName', '$teacherLastName', '$department', '$designation', '$teacherEmail', '$teacherPassword')";

if ($conn->query($sql) === TRUE) {
    echo "Record added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();

// Redirect back to the form or another page after processing
header("Location: teacher.html");
exit();
?>
