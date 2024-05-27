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
    <title>Add Subject Combination</title>
    <link rel="stylesheet" href="addelective.css">
</head>
<body>
    <div class="container">
        <h2>Add Subject Combination</h2>
        <form action="process_subject_combination.php" method="post">
            <div class="form-group">
                <label for="comboId">Combo ID:</label>
                <input type="text" name="comboId" required>
            </div>
            
            <div class="form-group">
                <label for="tid">Teacher ID:</label>
                <select name="tid" required>
                    <?php
$result = $conn->query("SELECT Tid FROM teacher");
while ($row = $result->fetch_assoc()) {
    echo "<option value='{$row['Tid']}'>{$row['Tid']}</option>";
}
?>
                </select>
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
                <label for="subCode">Subject Code:</label>
                <select name="subCode" required>
                    <?php


$sql = "SELECT SubCode, SubName FROM subjects";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
       echo "<option value='" . $row['SubCode'] . "'>" . $row['SubCode'] . "</option>";
    }
} else {
    echo "<option value=''>No subjects available</option>";
}
$conn->close();
?>
                </select>
            </div>
            <div class="form-group">
                <label for="sem">Semester</label>
                <select id="sem" name="sem">
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
                <label for="section">Section:</label>
                <select name="section" required>
                   <option value="A">A</option>
                   <option value="B">B</option>
                   <option value="C">C</option>
                </select>
            </div>
            <label for="elective" class="nostyle">Elective:</label>
            <input type="checkbox" id="elective" name="elective" value="1"><br><br>
            

          <div class="row">
        <input type="submit" value="Submit" class="btn btn-primary">
        <input type="reset" value="Reset" class="btn btn-reset">
    </div>
        </form>
    </div>
</body>
</html>
