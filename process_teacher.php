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


$teacherId = $_POST['teacherId'];
$teacherFirstName = $_POST['teacherFirstName'];
$teacherLastName = $_POST['teacherLastName'];
$department = $_POST['department'];
$designation = $_POST['designation'];
$teacherEmail = $_POST['teacherEmail'];
$teacherPassword = $_POST['teacherPassword'];


$sql = "INSERT INTO teacher (Tid, Teacher_FName, Teacher_LName, DeptId, Designation, Email, Password)
        VALUES ('$teacherId', '$teacherFirstName', '$teacherLastName', '$department', '$designation', '$teacherEmail', '$teacherPassword')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Teacher Detail Added succesfully'); window.location='addteacher.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();


exit();
?>
