<?php
session_start();
if(isset($_SESSION['username'])){
    $usn=$_SESSION['username'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otas";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$corrected_usn = $_POST['corrected_usn'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$semester = $_POST['semester'];
$section = $_POST['section'];
$email = $_POST['email'];


$sql = "INSERT INTO usercheck (usn,corrected_usn, fname,lname, semester, section, email) VALUES ('$usn', '$corrected_usn', '$fname', '$lname', '$semester', '$section', '$email')";
if ($conn->query($sql) === TRUE) {
    header("Location:complaint.html");
} }else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
?>