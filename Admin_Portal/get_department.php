<?php


$mysqli = new mysqli("your_host", "your_username", "your_password", "your_database");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT DeptId, DepName FROM department");

while ($row = $result->fetch_assoc()) {
    echo "<option value=\"{$row['DeptId']}\">{$row['DepName']}</option>";
}

$mysqli->close();
?>
