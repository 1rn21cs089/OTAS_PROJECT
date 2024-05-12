<?php
session_start();

if (isset($_SESSION['username'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $general_feedback = $_POST["General"];
        $website_experience = $_POST["OTAS"];
        $usn = $_SESSION['username'];

        
        $check_query = "SELECT * FROM student WHERE USN = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("s", $usn);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows == 0) {
            die("Error: Invalid USN provided.");
        }

       
        $insert_query = "INSERT INTO student_feedback (USN, FeedBack, WebFeedBack) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        if (!$insert_stmt) {
            die("Error in SQL query: " . $conn->error);
        }
        $insert_stmt->bind_param("sss", $usn, $general_feedback, $website_experience);
        if (!$insert_stmt->execute()) {
            die("Error: Unable to insert feedback.");
        }

        $insert_stmt->close();
        header("Location: logout.html");
        exit();
    }

    $conn->close();
} else {
    echo '<script>alert("Please login to continue.");</script>';
    header("Location: login.php");
    exit();
}
?>
