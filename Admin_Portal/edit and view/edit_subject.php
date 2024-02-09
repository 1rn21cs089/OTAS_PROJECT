<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $deptid = $_POST["deptid"];
    $subject = $_POST["subject"];
    $subname = $_POST["subname"];
    $sem = $_POST["sem"];
    $elective = $_POST["elective"];
    $core = $_POST["core"];
    
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otas";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare and bind the update statement
    $stmt = $conn->prepare("UPDATE subjects SET SubName=?, Sem=?, Elective=?, Core=? WHERE SubCode=? AND DeptId=?");
    $stmt->bind_param("siiiss", $subname, $sem, $elective, $core, $subject, $deptid);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Subject details updated successfully.";
    } else {
        echo "Error updating subject details: " . $conn->error;
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>