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

   
    $subquery = "SELECT Section, Sem FROM student WHERE USN = '$usn'";

    
    $subresult = $conn->query($subquery);
    if ($subresult->num_rows > 0) {
        
        $row = $subresult->fetch_assoc();
        $section = $row["Section"];
        $sem = $row["Sem"];

        
        $sql = "SELECT c.SubCode, su.SubName, t.Teacher_FName, t.Teacher_LName 
        FROM teacher_subcombo c
        JOIN subjects su ON su.SubCode = c.SubCode
        JOIN teacher t ON t.Tid = c.Tid
        JOIN student s ON s.Section = c.Section AND s.Sem = c.Sem
        WHERE Core = 1 AND c.Section = '$section' AND c.Sem = $sem AND s.USN LIKE '$usn' 
        ORDER BY c.SubCode" ;

       
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            
            echo "<table border='1'>";
            echo "<tr><th>Subject Code</th><th>Subject Name</th><th>Teacher Name</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["SubCode"]."</td><td>".$row["SubName"]."</td><td>".$row["Teacher_FName"]." ".$row["Teacher_LName"]."</td></tr>";
            }
            echo "</table>";
            echo "<form action='LabCheck.php' method='get'>";
            echo "<button type='submit' class='btn-blue'>Go to Lab Check</button>";
            echo "</form>";

            echo "</table>";
            echo "<form action='studentview.php' method='get'>";
            echo "<button type='submit' class='btn1-blue'>Go to User Details</button>";
            echo "</form>";
        } else {
            echo "0 results";
        }
    } else {
        echo "No section and sem found for the given USN.";
    }

    $conn->close();
} else {
    echo "Session not started or username not set.";
}
?>

<style>

body {
    background-image: url('Background.jpeg'); 
    background-size: cover;
    background-position: center;
    font-family: 'Times New Roman', sans-serif; 
    color: black;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
}

.table-container {
    width: 60%;
    margin: 0 auto; 
}

table {
    width: 100%;
    max-width: 100%;
    border-collapse: collapse;
    background-color: rgba(255, 255, 255, 0.8); 
}

th {
    background-color: #333;
    color: white;
    padding: 20px; 
    text-align: center;
    font-size: 40px; 
}

td {
    border: 1px solid #ddd;
    padding: 20px; 
    text-align: center;
    font-size: 32px; 
}

.error {
    color: red;
    font-weight: bold;
    margin: 20px;
}

.btn-blue {
    background-color: white;
    color: blue;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 20px;
    margin-top: 20px;
    position: fixed;
    bottom: 20px;
    right: 20px;
}

.btn-blue:hover{
background-color:#c9eaf7;
}

.btn1-blue {
    background-color: white;
    color: blue;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 20px;
    margin-top: 20px;
    position: fixed;
    bottom: 20px;
    left: 20px;
}

.btn1-blue:hover{
background-color:#c9eaf7;
}

</style>
