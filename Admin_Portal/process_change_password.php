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


$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];
$confirmPassword = $_POST['confirmPassword'];


if ($newPassword !== $confirmPassword) {
    echo "New password and confirm password do not match.";
    exit;
}


$currentUserId = $_SESSION['username'];
$sql = "SELECT Password FROM department WHERE DeptId = '$currentUserId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storedPassword = $row["Password"];

    if ($currentPassword !== $storedPassword) {
        echo "Current password is incorrect.";
        exit;
    }
} else {
    echo "Error: Department ID not found.";
    exit;
}


$sql = "UPDATE department SET Password = '$newPassword' WHERE DeptId = '$currentUserId'";

if ($conn->query($sql) === TRUE) {
    echo "Password changed successfully.";
} else {
    echo "Error updating password: " . $conn->error;
}

$conn->close();
?>