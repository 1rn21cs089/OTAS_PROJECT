<?php
// get_semesters.php - Fetch semesters from the database

$mysqli = new mysqli("your_host", "your_username", "your_password", "your_database");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT DISTINCT Sem FROM subjects");

while ($row = $result->fetch_assoc()) {
    echo "<option value=\"{$row['Sem']}\">{$row['Sem']}</option>";
}

$mysqli->close();
?>
