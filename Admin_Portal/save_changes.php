<?php
session_start();
if(isset($_SESSION['username'])){
    $mysqli = new mysqli("localhost", "root", "", "otas");

        if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
        }
}
else {
        echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}



$comboid = isset($_POST['comboid']) ? $_POST['comboid'] : null;
$teacherName = isset($_POST['teacherName']) ? $_POST['teacherName'] : null;
$subjectCode = isset($_POST['subjectCode']) ? $_POST['subjectCode'] : null;


if ($comboid === null || $teacherName === null || $subjectCode === null) {
    die("Missing data in the request");
}


$query = "SELECT tid FROM teacher WHERE CONCAT_WS(' ', Teacher_FName, Teacher_LName) = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $teacherName);
$stmt->execute();
$stmt->bind_result($tid);
$stmt->fetch();
$stmt->close();


$query = "UPDATE teacher_subcombo SET Tid = ?, Subcode = ? WHERE Comboid = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sss", $tid, $subjectCode, $comboid);
$success = $stmt->execute();
if (!$stmt->execute()) {
        echo "Error occurred while updating database: " . $mysqli->error;
        exit();
    }

$stmt->close();
 
    if ($success) {
        
        $query = "SELECT tsc.Comboid, CONCAT_WS(' ', t.Teacher_FName, t.Teacher_LName) as tname, tsc.Subcode, s.SubName
                  FROM teacher_subcombo AS tsc
                  INNER JOIN teacher t ON t.tid = tsc.tid
                  INNER JOIN subjects AS s ON s.Subcode = tsc.Subcode
                  WHERE tsc.Comboid = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $comboid);
        $stmt->execute();
        $stmt->bind_result($comboid, $tname, $subcode, $subname);
        $stmt->fetch();
        $stmt->close();

        
        $updatedData = array(
            'comboid' => $comboid,
            'teacherName' => $tname,
            'subjectCode' => $subcode,
            'subjectName' => $subname
        );

        
        echo json_encode($updatedData);
    } else {
        echo "Error occurred while saving changes";
    }
?>
