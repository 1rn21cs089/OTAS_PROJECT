<?php
session_start();

if(isset($_SESSION['username'])){
    $usn=$_SESSION['username'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otas";

    $conn = new mysqli($servername,$username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $usn = $_POST['usn'];
    $teacher_id = $_POST['teacher_id'];
    $subcode = $_POST['subcode'];
    $sem = $_POST['sem'];
    $section = $_POST['section'];
    $answers = $_POST['answer']; 
    $type=$_POST['type'];

    
    if ($type == "lab") {
        $table_name = "lab_response";
    } elseif ($type == "elective") {
        $table_name = "elective_response";
    } else {
        $table_name = "core_subject_response";
    }

    foreach($answers as $q_id => $rating) {
        try {
            
            $sql = "INSERT INTO $table_name (USN, Tid, SubCode, Sem, Section, q_Id, rating) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);

            if(!$stmt) {
                throw new Exception("Error preparing statement: " . $conn->error);
            }

            
            $stmt->bind_param("sssssss", $usn, $teacher_id, $subcode, $sem, $section, $q_id, $rating);

            
            if(!$stmt->execute()) {
                throw new Exception("Error executing statement: " . $stmt->error);
            }
        } catch(Exception $e) {
            
            echo "Error: " . $e->getMessage();
        }
    }

   
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Answers</title>
</head>
<body>
    <script>
        setTimeout(function(){ window.location.href = 'subject_questions.php'; }, 1000);
    </script>
</body>
