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

if (isset($_GET['Tid'])) {
    $teacherId = $_GET['Tid'];

    
    $sql = "SELECT 
    subjects.SubCode, 
    subjects.SubName,
    GROUP_CONCAT(DISTINCT teacher_subcombo.Sem ORDER BY teacher_subcombo.Sem ASC) AS Semesters, 
    teacher_subcombo.Tid,
    CONCAT(teacher.Teacher_FName, ' ', teacher.Teacher_LName) AS TeacherFullName
FROM 
    teacher_subcombo
INNER JOIN 
    subjects ON teacher_subcombo.SubCode = subjects.SubCode
INNER JOIN 
    teacher ON teacher_subcombo.Tid = teacher.Tid
WHERE 
    teacher_subcombo.Tid = $teacherId
GROUP BY 
    subjects.SubCode, teacher_subcombo.Tid;
";


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
