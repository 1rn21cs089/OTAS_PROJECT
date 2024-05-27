<?php
$tid = $_GET['tid'];


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otas";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM teacher WHERE Tid='$tid'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $teacher = $result->fetch_assoc();
    echo json_encode(array("success" => true, "teacher" => $teacher));
} else {
    echo json_encode(array("success" => false));
}

$conn->close();
?>
