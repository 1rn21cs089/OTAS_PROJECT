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


$sql = "SELECT SubCode, SubName, Sem, DeptId FROM subjects WHERE Elective = 1";
$result = $conn->query($sql);

$subjects = array();

if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
}


header('Content-Type: application/json');
echo json_encode($subjects);

$conn->close();
?>
