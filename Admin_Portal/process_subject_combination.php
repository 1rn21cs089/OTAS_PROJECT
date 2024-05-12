<?php
session_start();
if(isset($_SESSION['username'])){
}
else {
        echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otas";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comboId = $_POST["comboId"];
    $tid = $_POST["tid"];
    $subCode = $_POST["subCode"];
    $dept=$_POST["department"];
    $sem=$_POST["sem"];
    $section=$_POST["section"];
    $elective = isset($_POST['elective']) ? 1 : 0;
    $sql = "INSERT INTO teacher_subcombo (ComboId, Tid, SubCode,DeptId,Section,Sem, Elective) VALUES ('$comboId', '$tid', '$subCode','$dept','$section','$sem', '$elective')";

    if ($conn->query($sql) === TRUE) {
       echo "<script>alert('Subject-Combination Detail Added succesfully'); window.location='add_subject_combination.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
