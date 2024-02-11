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

if(isset($_POST['email'])) {
    $email = $_POST['email'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format";
        header("Location: forgot_password.php");
        exit();
    }

 
    $stmt = $conn->prepare("SELECT * FROM department WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $_SESSION['error'] = "Email not found";
        header("Location: forgot_password.php");
        exit();
    }

    // Generate a unique token
    $token = bin2hex(random_bytes(32));

    // Store token in the database along with email and timestamp
    $stmt = $conn->prepare("INSERT INTO password_resets (email, token, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();

    // Send email with reset link containing $token
    //$reset_link = "http://your_ip_address/reset_password.php?token=$token";
    //$reset_link = "http://localhost/reset_password.php?token=$token";
    $reset_link = "reset_password.php?token=$token";
    //ini_set("SMTP", "smtp.gmail.com");
//ini_set("smtp_port", "587");


    $email_subject = "Password Reset Request";
    $email_body = "Dear user,\n\nPlease click the following link to reset your password:\n$reset_link\n\nIf you did not request this, please ignore this email.";
    $headers = "From: ksjavali21@gmail.com";
    mail($email, $email_subject, $email_body, $headers);

    $_SESSION['success'] = "Password reset link sent to your email";
    echo 'Password reset link sent to your email';
    exit();
}
?>