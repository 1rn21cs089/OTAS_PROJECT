<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "otas";

$connection = mysqli_connect($hostname, $username, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

function getTeacherName($connection, $tid) {
    $query = "SELECT Teacher_FName, Teacher_LName FROM teacher WHERE Tid = '$tid'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['Teacher_FName'] . ' ' . $row['Teacher_LName'];
    } else {
        return "Error retrieving teacher name";
    }
}

function getSubjectName($connection, $subCode) {
    $query = "SELECT SubName FROM subjects WHERE SubCode = '$subCode'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['SubName'];
    } else {
        return "Error retrieving subject name";
    }
}

$query = "SELECT Sem, Section, Tid, SubCode FROM teacher_subcombo WHERE Elective = 1 ORDER BY SubCode ASC";
$result = mysqli_query($connection, $query);

if ($result) {
    echo "<div class='table-container'>";
    echo "<table border='1'>";
    echo "<tr><th>SubCode</th><th>Subject Name</th><th>Teacher Name</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $sem = $row['Sem'];
        $section = $row['Section'];
        $tid = $row['Tid'];
        $subCode = $row['SubCode'];

        $teacherName = getTeacherName($connection, $tid);
        $subjectName = getSubjectName($connection, $subCode);

        echo "<tr>";
        echo "<td>$subCode</td>";
        echo "<td>$subjectName</td>";
        echo "<td>$teacherName</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";

    
    echo "<form action='LabCheck.php' method='get'>";
    echo "<button type='submit' class='btn-blue'>Go to Lab Check</button>";
    echo "</form>";

} else {
    echo "Error retrieving data";
}

mysqli_close($connection);
?>
<style>

body {
    background-image: url('Background.jpeg'); 
    background-size: cover;
    background-position: center;
    font-family: 'Times New Roman', sans-serif; 
    color: black;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
}

.table-container {
    width: 60%;
    margin: 0 auto; 
}

table {
    width: 100%;
    max-width: 100%;
    border-collapse: collapse;
    background-color: rgba(255, 255, 255, 0.8); 
}

th {
    background-color: #333;
    color: white;
    padding: 20px; 
    text-align: center;
    font-size: 40px; 
}

td {
    border: 1px solid #ddd;
    padding: 20px; 
    text-align: center;
    font-size: 32px; 
}

.error {
    color: red;
    font-weight: bold;
    margin: 20px;
}

.btn-blue {
    background-color: blue;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 20px;
    margin-top: 20px;
}

</style>
