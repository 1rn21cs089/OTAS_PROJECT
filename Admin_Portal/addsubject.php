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
$dbname = "otas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="addsubject.css">
    <title>Add Subject</title>
</head>

<body>
    <div class="container">
        <h2>Add Subject</h2>
        <form action="process_form.php" method="post">
            <div class="form-group">
                <label for="department">Department</label>
                <select id="department" name="department">
                    <?php
                   
                    $result = $conn->query("SELECT DeptId, DepName FROM department");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value=\"{$row['DeptId']}\">{$row['DepName']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="semester">Semester</label>
                <select id="semester" name="semester">
                    <?php
                    
                    $result = $conn->query("SELECT DISTINCT Sem FROM subjects");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value=\"{$row['Sem']}\">{$row['Sem']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="subjectCode">Subject Code</label>
                <input type="text" id="subjectCode" name="subjectCode" placeholder="Enter Subject Code">
            </div>

            <div class="form-group">
                <label for="subjectName">Subject Name</label>
                <input type="text" id="subjectName" name="subjectName" placeholder="Enter Subject Name">
            </div>
            <div class="row">
                <input type="submit" value="Submit" class="btn btn-primary">
                <input type="reset" value="Reset" class="btn btn-reset">
            </div>
        </form>
    </div>
</body>

</html>
<?php

$conn->close();
?>
