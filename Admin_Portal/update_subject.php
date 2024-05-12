<?php
session_start();
if(isset($_SESSION['username'])){
}
else {
        echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $subCode = $_POST['subCode'];
    $subName = $_POST['subName'];
    $sem = $_POST['sem'];
    $elective = $_POST['elective'];
    $deptId = $_POST['deptId'];

    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $sql = "UPDATE subjects SET SubName=?, Sem=?, Elective=?, DeptId=? WHERE SubCode=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiss", $subName, $sem, $elective, $deptId, $subCode);

    
    if ($stmt->execute()) {
        echo "<script>alert('Subject details updated successfully'); window.location='edit_subject.php';</script>";
    } else {
        echo "Error updating subject details: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} 
?>
