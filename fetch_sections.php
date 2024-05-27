<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otas";
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['semester'])) {
    $semester = $_GET['semester'];
    $sql = "SELECT DISTINCT Section FROM student WHERE Sem = $semester ORDER BY Section ASC";
    $result = $conn->query($sql);
    $sections = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sections[] = $row['Section'];
        }
    }
    echo json_encode($sections);
}
?>
