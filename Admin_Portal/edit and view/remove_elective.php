<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otas";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape user inputs to prevent SQL injection
    $sub_code = $conn->real_escape_string($_POST['sub_code']);

    // SQL to delete elective based on subject code
    $sql = "DELETE FROM subjects WHERE SubCode = '$sub_code' AND Elective = 1";

    if ($conn->query($sql) === TRUE) {
        echo "Elective removed successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
