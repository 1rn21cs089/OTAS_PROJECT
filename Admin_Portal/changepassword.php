<?php
session_start();
if(isset($_SESSION['username'])){
}
else {
        echo '
<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_change_password.css">

    <title>Admin Page</title>
</head>
<body>
    <h2>Change Password</h2>
    <form action="process_change_password.php" method="post">
        <div class="form-group">
            <label for="currentPassword">Current Password:</label>
            <input type="password" id="currentPassword" name="currentPassword" required>
        </div>

        <div class="form-group">
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" required>
        </div>

        <div class="form-group">
            <label for="confirmPassword">Confirm New Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
        </div>

        <div class="form-group">
            <button type="submit">Change Password</button>
        </div>
    </form>
</body>
</html>
