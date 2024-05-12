<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otas";
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['semester']) && isset($_GET['section'])) {
    $semester = $_GET['semester'];
    $section = $_GET['section'];

    
    $sql = "SELECT teacher.Teacher_FName, teacher.Teacher_LName, teacher_subcombo.SubCode, subjects.SubName,
        (CASE WHEN teacher_subcombo.Elective = 0 THEN 'False' ELSE 'True' END) AS Electives
        FROM teacher
        JOIN teacher_subcombo ON teacher_subcombo.Tid = teacher.Tid
        JOIN subjects ON teacher_subcombo.SubCode = subjects.SubCode
        WHERE teacher_subcombo.Sem = $semester AND teacher_subcombo.Section = '$section'
        ORDER BY teacher_subcombo.SubCode";


    $result = $conn->query($sql);

    $teacherDetails = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $teacherDetails[] = $row;
        }
    }

    echo json_encode($teacherDetails);
}
?>
