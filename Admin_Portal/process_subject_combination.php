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
   
    $sql = "INSERT INTO teacher_subcombo (ComboId, Tid, SubCode,DeptId,Section,Sem) VALUES ('$comboId', '$tid', '$subCode','$dept','$section','$sem')";

    if ($conn->query($sql) === TRUE) {
        echo "Subject combination added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
