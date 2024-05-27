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
$database = "otas";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ? AND created_at >= DATE_SUB(NOW(), INTERVAL 1 HOUR)");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $_SESSION['error'] = "Invalid or expired token";
        header("Location: forgot_password.php");
        exit();
    }

    $row = $result->fetch_assoc();
    $email = $row['email'];

    if(isset($_POST['password'])) {
        $password = $_POST['password'];
        if (strlen($password) < 8) {
            $_SESSION['error'] = "Password must be at least 8 characters long";
            header("Location: reset_password.php?token=$token");
            exit();
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();


        $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $_SESSION['success'] = "Password reset successfully";
        header("Location: login.html");
        exit();
    }
} else {
    $_SESSION['error'] = "Token not provided";
    header("Location: forgot_password.php");
    exit();
}
?>