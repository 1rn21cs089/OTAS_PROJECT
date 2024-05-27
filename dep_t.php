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
    <link rel="stylesheet" href="addelective.css">
    <title>Add Teacher</title>
</head>

<body>
    <div class="container">
        <h2>Add Teacher</h2>
        <form action="dep_t1.php" method="post">
            <div class="form-group">
                <label for="teacherId">Teacher ID</label>
                <input type="text" id="teacherId" name="teacherId" placeholder="Enter Teacher ID">
            </div>

            <div class="form-group">
                <label for="teacherFirstName">First Name</label>
                <input type="text" id="teacherFirstName" name="teacherFirstName" placeholder="Enter First Name">
            </div>

            <div class="form-group">
                <label for="teacherLastName">Last Name</label>
                <input type="text" id="teacherLastName" name="teacherLastName" placeholder="Enter Last Name">
            </div>

            <div class="form-group">
                <label for="department">Department</label>
                <select id="department" name="department">
                <?php
$mysqli = new mysqli("localhost", "root", "", "otas");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT DeptId, DepName FROM department");

while ($row = $result->fetch_assoc()) {
    echo "<option value=\"{$row['DeptId']}\">{$row['DepName']}</option>";
}

$mysqli->close();
?>

                </select>
            </div>

            <div class="form-group">
                <label for="designation">Designation</label>
                <input type="text" id="designation" name="designation" placeholder="Enter Designation">
            </div>

            <div class="form-group">
                <label for="teacherEmail">Email</label>
                <input type="email" id="teacherEmail" name="teacherEmail" placeholder="Enter Email">
            </div>

            <div class="form-group">
                <label for="teacherPassword">Password</label>
                <input type="password" id="teacherPassword" name="teacherPassword" placeholder="Enter Password">
            </div>

            <div class="row">
                <input type="submit" value="Submit" class="btn btn-primary">
                <input type="reset" value="Reset" class="btn btn-reset">
            </div>
        </form>
    </div>
</body>

</html>
