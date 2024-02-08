<?php
session_start();
if(isset($_SESSION['username'])){

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otas";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $general_feedback = $_POST["General"];
    $website_experience = $_POST["OTAS"];
    $usn=$_SESSION['username'];
 
    $sql = "INSERT INTO student_feedback (USN,General, OTAS) VALUES (?,?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
    die("Error in SQL query: " . $conn->error);
}
    $stmt->bind_param("sss", $usn,$general_feedback, $website_experience);
    $stmt->execute();
    $stmt->close();  
    header("Location:logout.html");
}
$conn->close();
}
else{
 echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.html");}
?>

