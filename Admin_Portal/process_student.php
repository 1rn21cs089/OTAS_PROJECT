<?php
// process_student.php - Handle student form submissions

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
$usn = $_POST['usn'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phoneNumber = $_POST['phoneNumber'];
$semester = $_POST['semester'];
$email = $_POST['email'];
$department = $_POST['department'];
$batch = $_POST['batch'];
$section = $_POST['section'];
$isValid = $_POST['isValid'];
$password = $_POST['password'];

// SQL query to insert data into the database
$sql = "INSERT INTO student (USN, First_Name, Last_Name, Phone_Number, Sem, Email, Dept_Id, Batch, Section, Is_Valid, Password)
        VALUES ('$usn', '$firstName', '$lastName', '$phoneNumber', '$semester', '$email', '$department', '$batch', '$section', '$isValid', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Record added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();

// Redirect back to the form or another page after processing
header("Location: student.html");
exit();
?>
