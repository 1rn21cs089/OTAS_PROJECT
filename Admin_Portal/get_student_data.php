<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otas";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usn = $_POST['usn'];

    $sql = "SELECT * FROM student WHERE USN = '$usn'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        $row = $result->fetch_assoc();
        echo json_encode($row); 
    } else {
        echo "No results found";
    }
}
$conn->close();
?>
