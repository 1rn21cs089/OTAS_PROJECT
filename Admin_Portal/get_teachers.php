<?php

$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT Tid, Teacher_FName FROM teacher");
while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row['Tid']}'>{$row['Teacher_FName']}</option>";
}

$conn->close();
?>
