<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otas";

$conn = new mysqli($servername, 
	$username, $password, $dbname);

if ($conn->connect_error) {
	die("Connection failed: "
		. $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['mobile'];
    $email = $_POST['email'];
    $usn=$_SESSION['username'];
	$updateQuery = "UPDATE student SET Phone_Number = ?, Email = ? WHERE usn = ?";
$stmt = $conn->prepare($updateQuery);

if ($stmt) {
     $stmt->bind_param("sss", $phone, $email, $usn);
    if ($stmt->execute()) {
        header("Location:instruction.html");
    } else {
        echo "Error: ". $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error in preparing statement: " . $conn->error;
}

$conn->close();
}
?>