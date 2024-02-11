<?php

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
    $username = $_POST['Username'];
    $passw = $_POST['Password'];

$stmt = $conn->prepare("SELECT * FROM department WHERE deptid = ? AND password = ?");
$stmt->bind_param("ss", $username, $passw);
$stmt->execute();
$result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hash_passw = $row['Password'];

        if ($passw==$hash_passw){
            session_start();
            $_SESSION['username']=$username;
            header("Location:home.php");
            exit(); 
        } else {
            echo "<h3>Login failed. Incorrect Password!</h3>";
        }
    } else {
        echo "<h3>Login failed. User Not Found!</h3>";
    }

    $stmt->close();
    $conn->close();
}
?>
