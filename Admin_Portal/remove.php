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

if (isset($_GET['SubCode'])) {
    $subCode = $_GET['SubCode'];
    
    
    $sql = "DELETE FROM subjects WHERE SubCode = '$subCode'";

    if ($conn->query($sql) === TRUE) {
        header("Location: remove_elective.php");
    } else {
        echo "Error removing subject: " . $conn->error;
    }
} else {
    echo "Subject SubCode not provided";
}

$conn->close();
?>
