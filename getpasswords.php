<?php
session_start();
if(isset($_SESSION['username'])){
}
else {
        echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}
if(isset($_GET['usn']) && !empty($_GET['usn'])) {
    $usn = $_GET['usn'];

    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $sql = "SELECT Password FROM student WHERE USN=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password = $row['Password'];
        echo json_encode(array("success" => true, "password" => $password));
    } else {
        echo json_encode(array("success" => false, "message" => "No password found for the provided USN."));
    }

    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(array("success" => false, "message" => "No USN provided."));
}
?>
