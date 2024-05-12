<?php
session_start();
if(isset($_SESSION['username'])){
}
else {
        echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $usn = $_POST['usn'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $sem = $_POST['sem'];
    $email = $_POST['email'];
    $deptId = $_POST['deptId'];
    $batch = $_POST['batch'];
    $section = $_POST['section'];
    $password = $_POST['password'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "UPDATE student SET First_Name=?, Last_Name=?, Phone_Number=?, Sem=?, Email=?, Dept_Id=?, Batch=?, Section=?, Password=? WHERE USN=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $fname, $lname, $phone, $sem, $email, $deptId, $batch, $section, $password, $usn);

    
    if ($stmt->execute()) {
        echo "<script>alert('Student details updated successfully'); window.location='edit_student.php';</script>";
    } else {
        echo "Error updating student details: " . $conn->error;
    }

    
    $stmt->close();
    $conn->close();
} else {
    
        header("Location: edit_student.php");
    exit();
}
?>
