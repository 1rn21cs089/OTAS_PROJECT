<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['Username'];
    $passw = $_POST['Password'];

    $stmt = $conn->prepare("SELECT 
    CASE
        WHEN deptid = ? AND password = ? THEN 'home.php'
        WHEN Admin_user = ? AND Admin_pass = ? THEN 'details.php'
        ELSE NULL
    END AS redirect_page
FROM department
WHERE (deptid = ? AND password = ?) OR (Admin_user = ? AND Admin_pass = ?)");
    $stmt->bind_param("ssssssss", $username, $passw, $username, $passw, $username, $passw, $username, $passw);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    $redirect_page = $row ? $row['redirect_page'] : null; 

    if ($redirect_page) {
        session_start();
        $_SESSION['username'] = $username;
        header("Location: $redirect_page");
        exit();
    } else {
        
        echo "<script>alert('Login failed. Incorrect Username or Password!'); window.location.href = 'login.html';</script>";
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
