<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$database = "otas";


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if(isset($_GET['comboId'])) {
    $comboId = $_GET['comboId'];

    
    $stmt = $conn->prepare("SELECT * FROM teacher_subcombo WHERE ComboId = ?");
    $stmt->bind_param("s", $comboId);
    $stmt->execute();

    
    if($stmt->error) {
        echo "SQL Error: " . $stmt->error;
    }

    
    $result = $stmt->get_result();

    
    if($result->num_rows > 0) {
        
        $teacherSubCombo = $result->fetch_assoc();

        
        echo json_encode(array(
            'success' => true,
            'teacherSubCombo' => $teacherSubCombo
        ));
    } else {
        
        echo json_encode(array(
            'success' => false,
            'message' => 'Combo ID not found.'
        ));
    }

    
    $stmt->close();
} else {
    
    echo json_encode(array(
        'success' => false,
        'message' => 'Combo ID is missing in the request.'
    ));
}


$conn->close();
?>
