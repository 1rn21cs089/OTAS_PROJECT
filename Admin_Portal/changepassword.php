<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Change Password</title>
<style>
.container {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input {
  width: 100%;
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

button {
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}
</style>
</head>
<body>
<div class="container">
  <h2>Change Password</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-group">
      <label for="usn">Enter USN:</label>
      <input type="text" id="usn" name="usn" required>
    </div>
    <div class="form-group">
      <label for="new_password">Enter New Password:</label>
      <input type="password" id="new_password" name="new_password" required>
    </div>
    <button type="submit">Change Password</button>
  </form>
</div>
<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "otas"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $usn = $_POST['usn'];
    $new_password = $_POST['new_password'];

    
    $sql = "UPDATE student SET password = '$new_password' WHERE usn = '$usn'";

    if ($conn->query($sql) === TRUE) {
       echo "<script>alert('Password updated successfully to: " . $new_password . "'); window.location='changepassword.php';</script>";
    } else {
        echo "<p>Error updating password: " . $conn->error . "</p>";
    }

    $conn->close();
}
?>
</body>
</html>
