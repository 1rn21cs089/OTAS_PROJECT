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
    <link rel="stylesheet" href="addstudent.css">
    <title>Add Student</title>
</head>

<body>
    <div class="container">
        <h2>Add Student</h2>
        <form action="process_student.php" method="post">
            <div class="form-group">
                <label for="usn">USN</label>
                <input type="text" id="usn" name="usn" placeholder="Enter USN">
            </div>

            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" placeholder="Enter First Name">
            </div>

            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" placeholder="Enter Last Name">
            </div>

            <div class="form-group">
                <label for="phoneNumber">Phone Number</label>
                <input type="text" id="phoneNumber" name="phoneNumber" placeholder="Enter Phone Number">
            </div>

            <div class="form-group">
                <label for="semester">Semester</label>
                <select id="semester" name="semester">
                    <?php
$mysqli = new mysqli("localhost", "root", "", "otas");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT DISTINCT Sem FROM subjects");

while ($row = $result->fetch_assoc()) {
    echo "<option value=\"{$row['Sem']}\">{$row['Sem']}</option>";
}

$mysqli->close();
?>
                </select>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Email">
            </div>

            <div class="form-group">
    <label for="department">Department</label>
    <select id="department" name="department">
        <?php 
        session_start();

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
        <label for="batch">Batch</label>
        <input type="text" id="batch" name="batch" placeholder="Enter Batch">
    </div>

    <div class="form-group">
        <label for="section">Section</label>
        <input type="text" id="section" name="section" placeholder="Enter Section">
    </div>

    <div class="form-group">
        <label for="isValid">Is Valid</label>
        <select id="isValid" name="isValid">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter Password">
    </div>

    <div class="row">
        <input type="submit" value="Submit" class="btn btn-primary">
        <input type="reset" value="Reset" class="btn btn-reset">
    </div>
    </form>
    </div>
</body>

</html>
