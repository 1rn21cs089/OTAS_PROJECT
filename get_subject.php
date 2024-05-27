<?php

if (isset($_GET['subCode'])) {
    
    $subCode = $_GET['subCode'];

    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $sql = "SELECT * FROM subjects WHERE SubCode = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $subCode);

    
    $stmt->execute();

    
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0) {
        
        $subject = $result->fetch_assoc();

        
        echo json_encode(['success' => true, 'subject' => $subject]);
    } else {
        
        echo json_encode(['success' => false, 'error' => 'Subject not found']);
    }

    
    $stmt->close();
    $conn->close();
} else {
    
    echo json_encode(['success' => false, 'error' => 'Subject code is required']);
}
?>
