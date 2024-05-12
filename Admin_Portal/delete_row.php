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

if (isset($_POST['comboid'])) {
    
   $comboid = $_POST['comboid'];
    $query = "DELETE FROM teacher_subcombo WHERE comboid = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $comboid);
    $stmt->execute();
    if ($stmt->affected_rows >= 0) {
        echo "Successfully deleted the row with comboid: " . $comboid;
    } else {
        echo "Failed to delete the row with comboid: " . $comboid;
    }

    $stmt->close();
    $mysqli->close();
} else {
    echo "comboid not provided";
}
?>
