<?php
// Assuming you have already established a connection to your database
// Replace placeholders with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otas";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $usn = $_POST['usn'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $sem = $_POST['sem'];
    $email = $_POST['email'];
    $dept_id = $_POST['dept_id'];
    $batch = $_POST['batch'];
    $section = $_POST['section'];
    $is_valid = $_POST['is_valid'];
    $password = $_POST['password'];

    // SQL to update student details
    $sql = "UPDATE student SET 
            First_Name = '$first_name', 
            Last_Name = '$last_name', 
            Phone_Number = '$phone_number', 
            Sem = $sem, 
            Email = '$email', 
            Dept_Id = '$dept_id', 
            Batch = $batch, 
            Section = '$section', 
            Is_Valid = $is_valid, 
            Password = '$password' 
            WHERE USN = '$usn'";

    if ($conn->query($sql) === TRUE) {
        echo "Student details updated successfully";
    } else {
        echo "Error updating student details: " . $conn->error;
    }
}
$conn->close();
?>
