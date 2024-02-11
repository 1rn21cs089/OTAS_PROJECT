<?php
session_start();
if(isset($_SESSION['username'])){
}
else {
        echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otas";


    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    $subCode = $_POST['subCode'];
    $subName = $_POST['subName'];
    $semester = $_POST['semester'];
    $elective = isset($_POST['elective']) ? 1 : 0;
    $deptId = $_POST['department'];
  $sql = "INSERT INTO subjects (SubCode, SubName, Sem, Elective, DeptId)
            VALUES ('$subCode', '$subName', '$semester', '$elective', '$deptId')";

    if ($conn->query($sql) === TRUE) {
        echo "Subject added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    
    $conn->close();
} 

?>
