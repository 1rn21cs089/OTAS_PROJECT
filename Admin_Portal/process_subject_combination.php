<?php
// Connect to your database (replace with your actual database credentials)
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comboId = $_POST["comboId"];
    $tid = $_POST["tid"];
    $subCode = $_POST["subCode"];
    // Add other form fields as needed

    // SQL statement to insert data into the teacher_subcombo table
    $sql = "INSERT INTO teacher_subcombo (ComboId, Tid, SubCode) VALUES ('$comboId', '$tid', '$subCode')";

    if ($conn->query($sql) === TRUE) {
        echo "Subject combination added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
