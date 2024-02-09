<?php
// edit_teacher.php
$host = 'localhost';
$dbname = 'otas';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $tid = $_POST["tid"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $dept = $_POST["dept"];
    $designation = $_POST["designation"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Update teacher details in the database
    $sql = "UPDATE teacher SET Teacher_FName='$fname', Teacher_LName='$lname', DeptId='$dept', Designation='$designation', Email='$email', Password='$password' WHERE Tid='$tid'";

    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
