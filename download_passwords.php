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


$branch = $_POST['branch'];
$sem = $_POST['sem'];
$sec = $_POST['sec'];


$query = "SELECT usn, First_Name, Last_Name, Password FROM student WHERE Dept_Id = ? AND Sem = ? AND Section = ?";
$stmt = $mysqli->prepare($query);


if ($stmt === false) {
    die("Error in SQL query: " . $mysqli->error);
}

$stmt->bind_param("sss", $branch, $sem, $sec);
$stmt->execute();
$result = $stmt->get_result();


$students = array();
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

$stmt->close();


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
$pdf->Cell(0, 10, 'Branch: ' . $branch, 0, 1);
$pdf->Cell(0, 10, 'Semester: ' . $sem, 0, 1);
$pdf->Cell(0, 10, 'Section: ' . $sec, 0, 1);
$pdf->Ln();


$header = array('Sl.No', 'Full Name', 'USN', 'Password');
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(20, 10, $header[0], 1, 0, 'C'); 
$pdf->Cell(90, 10, $header[1], 1, 0, 'C');
$pdf->Cell(40, 10, $header[2], 1, 0, 'C');  
$pdf->Cell(40, 10, $header[3], 1, 0, 'C'); 
$pdf->Ln();



$slNo = 1;


foreach ($students as $student) {
    $fullName = $student['First_Name'] . ' ' . $student['Last_Name'];
    
    if (empty($student['Password'])) {
        $password = generatePassword();
        
        $updateQuery = "UPDATE student SET Password = ? WHERE usn = ?";
        $updateStmt = $mysqli->prepare($updateQuery);
        if ($updateStmt === false) {
            die("Error in SQL query: " . $mysqli->error);
        }
        $updateStmt->bind_param("ss", $password, $student['usn']);
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        $password = $student['Password'];
    }
    
    $pdf->Cell(20, 10, $slNo++, 1, 0, 'C'); 
    $pdf->Cell(90, 10, $fullName, 1, 0);
    $pdf->Cell(40, 10, $student['usn'], 1, 0, 'C');
    $pdf->Cell(40, 10, $password, 1, 1, 'C');
}



$mysqli->close();


$pdf->Output('student_passwords.pdf', 'D');

exit;


function generatePassword() {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < 8; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}
?>
