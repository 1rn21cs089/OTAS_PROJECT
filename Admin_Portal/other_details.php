<?php

$mysqli = new mysqli("localhost", "root", "", "otas");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


$subjectName = $_POST['subjectName'];
$subjectCode = $_POST['subjectCode'];

$query = "SELECT t.DeptId AS teacherDepartment, s.DeptId AS subjectDepartment
          FROM subjects s
          INNER JOIN teacher_subcombo c ON s.subcode = c.subcode
          INNER JOIN teacher t ON c.tid = t.tid
          WHERE s.SubName = ? AND s.SubCode = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ss", $subjectName, $subjectCode);
$stmt->execute();
$result = $stmt->get_result();


$row = $result->fetch_assoc();

echo json_encode($row);

$stmt->close();
$mysqli->close();
?>
