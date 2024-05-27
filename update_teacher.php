<?php
session_start();
if(isset($_SESSION['username'])){
}
else {
        echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $tid = $_POST['tid'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $deptId = $_POST['deptId'];
    $designation = $_POST['designation'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $sql = "UPDATE teacher SET Teacher_FName=?, Teacher_LName=?, DeptId=?, Designation=?, Email=?, Password=? WHERE Tid=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $fname, $lname, $deptId, $designation, $email, $password, $tid);

    
    if ($stmt->execute()) {
        echo "<script>alert('Teacher details updated successfully'); window.location='edit_teacher.php';</script>";
    } else {
        echo "Error updating teacher details: " . $conn->error;
    }

    
    $stmt->close();
    $conn->close();
} else {
    
    header("Location: edit_teacher.html");
    exit();
}
?>
