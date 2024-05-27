<?php
session_start();
if(isset($_SESSION['username'])){
}
else {
    echo '<script>alert("Please login to continue.");</script>';
    header("Location:login.html");
}
require_once('tcpdf/tcpdf.php');

$mysqli = new mysqli("localhost", "root", "", "otas");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Retrieve data from the form
$sem = $_POST['sem'];

// SQL query based on the provided requirement
$query = "SELECT usn, First_Name, Last_Name FROM student s
          WHERE s.Sem = ? 
          AND NOT EXISTS (
              SELECT 1 FROM core_subject_response c
              WHERE s.USN = c.USN AND s.Sem = ? 
          )";
$stmt = $mysqli->prepare($query);

if ($stmt === false) {
    die("Error in SQL query: " . $mysqli->error);
}

$stmt->bind_param("ss", $sem, $sem);
$stmt->execute();
$result = $stmt->get_result();

// Fetching data from the database
$students = array();
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}
$stmt->close();

// Creating PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('RNSIT');
$pdf->SetTitle('Student Passwords');
$pdf->SetSubject('Student Passwords');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetFont('helvetica', '', 10);

$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'RNSIT: ', 0, 1);
$pdf->Cell(0, 10, 'Semester: ' . $sem, 0, 1);
$pdf->Ln();

$header = array('Sl.No', 'USN', 'Full Name');
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(20, 10, $header[0], 1, 0, 'C'); 
$pdf->Cell(40, 10, $header[1], 1, 0, 'C'); 
$pdf->Cell(130, 10, $header[2], 1, 0, 'C'); 
$pdf->Ln();

$slNo = 1;
foreach ($students as $student) {
    $fullName = $student['First_Name'] . ' ' . $student['Last_Name'];
    $pdf->Cell(20, 10, $slNo++, 1, 0, 'C'); 
    $pdf->Cell(40, 10, $student['usn'], 1, 0, 'C');
    $pdf->Cell(130, 10, $fullName, 1, 1);
}

$mysqli->close();

$pdf->Output('student_absentees.pdf', 'D');
exit;
?>
