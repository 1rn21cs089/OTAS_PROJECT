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

$semester = $_POST['semester'];
$subject = $_POST['subjectName'];
$department = $_POST['department'];
$subjectCode = $_POST['subjectCode'];


$sql = "INSERT INTO subjects ( Sem, SubName, DeptId, SubCode)
        VALUES ( '$semester', '$subject', '$department','$subjectCode')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Teacher Detail Added succesfully'); window.location='addteacher.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();



exit();
?>
