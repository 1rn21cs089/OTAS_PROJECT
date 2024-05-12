<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otas";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$usn = $_POST['usn'];


$stmt = $conn->prepare("SELECT First_Name, Last_Name, Sem, Section FROM student WHERE USN=?");
$stmt->bind_param("s", $usn);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($first_name, $last_name, $sem, $section);
    $stmt->fetch();
    $student_name = $first_name . " " . $last_name;
    $class_section = $sem . "-" . $section;

   
    $_SESSION['student_name'] = $student_name;
    $_SESSION['class_section'] = $class_section;
    $_SESSION['usn'] = $usn;

   
    header("Location: dashboard.php");
    exit();
} else {
    
    $_SESSION['login_error'] = "Invalid USN";
    header("Location: login.php");
    exit();
}

$stmt->close();
$conn->close();
?>