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


$usn = $_POST['usn'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phoneNumber = $_POST['phoneNumber'];
$semester = $_POST['semester'];
$email = $_POST['email'];
$department = $_POST['department'];
$batch = $_POST['batch'];
$section = $_POST['section'];
$isValid = $_POST['isValid'];
$password = $_POST['password'];


$sql = "INSERT INTO student (USN, First_Name, Last_Name, Phone_Number, Sem, Email, Dept_Id, Batch, Section, Is_Valid, Password)
        VALUES ('$usn', '$firstName', '$lastName', '$phoneNumber', '$semester', '$email', '$department', '$batch', '$section', '$isValid', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Record added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();


//header("Location: student.html");
exit();
?>
