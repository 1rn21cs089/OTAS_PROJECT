<?php
session_start();
if(isset($_SESSION['username'])){
    $usn=$_SESSION['username'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(isset($_POST['editedData'])) {
        foreach ($_POST['editedData'] as $subcode => $values) {
            $newSubcode = $values['subcode'];
            $newSubname = $values['subname'];
            $newTeachername = $values['teachername'];

            $sql = "INSERT INTO electivecheck (usn, subcode, subname, teachername) VALUES ('$usn', '$newSubcode', '$newSubname', '$newTeachername')";
            
            if ($conn->query($sql) !== TRUE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
                
            }
            else{
                header("Location:complaint.php");
            }
        }
    }

    $conn->close();
} else {
    echo "Session not started or username not set.";
}
?>
