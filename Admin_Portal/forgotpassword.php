<?php
session_start();
if(isset($_SESSION['username'])){

}
else {
        echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h1>Forgot Password</h1>
    <form action="forgot_password.php" method="post">
        <input type="email" name="email" placeholder="Enter your email" required><br><br>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>