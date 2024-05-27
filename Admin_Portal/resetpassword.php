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
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>
    <?php if(isset($_GET['token'])): ?>
    <?php
    $token = $_GET['token'];
    ?>
    <form action="reset_password.php" method="post">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <input type="password" name="password" placeholder="Enter new password" required><br><br>
        <input type="password" name="confirm_password" placeholder="Confirm new password" required><br><br>
        <button type="submit">Reset Password</button>
    </form>
    <?php else: ?>
    <p>Token not provided</p>
    <?php endif; ?>
</body>
</html>