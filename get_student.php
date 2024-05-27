<?php

$host = "localhost";
$dbname = "otas";
$username = "root";
$password = "";

try {
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}


if(isset($_GET['usn'])) {
    $usn = $_GET['usn'];

    
    $stmt = $pdo->prepare("SELECT * FROM student WHERE USN = ?");
    $stmt->execute([$usn]);

    
    if($stmt->rowCount() > 0) {
        
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        $response = [
            'success' => true,
            'student' => $student
        ];
    } else {
        
        $response = [
            'success' => false
        ];
    }

    
    echo json_encode($response);
} else {
    
    echo json_encode(['error' => 'Parameter "usn" is required']);
}
?>
