<?php
session_start();
if(isset($_SESSION['username'])){
}
else {
        echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otas";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $usn = $_POST['usn'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $sem = $_POST['sem'];
    $email = $_POST['email'];
    $dept_id = $_POST['dept_id'];
    $batch = $_POST['batch'];
    $section = $_POST['section'];
    
    
    $sql = "UPDATE student SET First_Name='$first_name', Last_Name='$last_name', Phone_Number='$phone_number', Sem=$sem, Email='$email', Dept_Id='$dept_id', Batch=$batch, Section='$section' WHERE USN='$usn'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Student details updated successfully'); window.location='edit_student.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
$conn->close();
?>
