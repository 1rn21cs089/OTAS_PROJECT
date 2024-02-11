<?php
session_start();
if(isset($_SESSION['username'])){
    $usn=$_SESSION['username'];
    $servername = "localhost";
$username = "root";
$password = "";
$dbname = "otas";

$conn = new mysqli($servername,
	$username, $password, $dbname);

if ($conn->connect_error) {
	die("Connection failed: "
		. $conn->connect_error);
}
$studentInfoQuery = "SELECT * FROM student WHERE usn = ? LIMIT 1";
    $stmt = $conn->prepare($studentInfoQuery);
    $stmt->bind_param("s", $usn);
    $stmt->execute();
    $studentInfoResult = $stmt->get_result();
    if (!$studentInfoResult) {
        die("Error in query execution: " . $conn->error);
    }
    if ($studentInfoResult->num_rows > 0) {
        $studentInfoRow = $studentInfoResult->fetch_assoc();
    } else {
        echo "Student information not found for the provided Username.";
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Please login to continue";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIEW1</title>
    <style>        
        @keyframes fadeInAnimation {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        .col-md-10{
            padding-left: 20px;
        }
        body {
            opacity: 0;
            animation: fadeInAnimation 2s ease-in-out forwards;
            background-image: url("b2.jpg"); 
            background-position: center;
            background-size: cover;
            background-color: rgb(255, 255, 255);
            color: rgb(255, 255, 255);
            margin: 10px;
            display: flex;
            align-items: center;
            background-attachment: fixed;
            width: 100%;
            padding-left: 100px;
            height: 100vh;
            border-radius: 10px;
            filter: brightness(100%); 
        }                   
        hr {
            color: rgb(255, 255, 255);
        }
        .Page {
            font-size: 1.3em;
        }
        .Student-Details .row {
            margin: 10px 0;
            padding-left: 20px;
        }
        .text-danger {
            color: rgb(255, 255, 255);
            margin-top: 5px;
        }
        .line_break {
            border-width: 0.5px;
            border-style: solid;
            border-color: rgb(255, 255, 255);
        }
        .btn-blue {
            background-color: blue;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

    </style>
</head>
<body id="for_body">

    <div class="wow fadeIn Page" style="padding:20px;width: 80%;background: rgba(54, 25, 25, 0.4);border-radius: 10px;">
        <h4 style="font-family:'Arial Rounded MT';">Your Details</h4>
        <hr>
        <div class="Student-Details">
            <div class="row">
                <div style="font-family:'Arial Rounded MT';">
                USN: <?php echo isset($studentInfoRow["USN"]) ? $studentInfoRow["USN"] : 'Not available'; ?>
                </div>
                
            </div>
            <div class="row">
                <div style="font-family:'Arial Rounded MT';">
                        Name: <?php echo isset($studentInfoRow["First_Name"]) ? $studentInfoRow["First_Name"] : 'Not available'; ?> <?php echo isset($studentInfoRow["Last_Name"]) ? $studentInfoRow["Last_Name"] : ''; ?>
                </div>
                
            </div>
            <div class="row">
                <div style="font-family:'Arial Rounded MT';">
                        Semester: <?php echo isset($studentInfoRow["Sem"]) ? $studentInfoRow["Sem"] : 'Not available'; ?>
                </div>
                
            </div>
            <div class="row">
                <div style="font-family:'Arial Rounded MT';">
                        Section: <?php echo isset($studentInfoRow["Section"]) ? $studentInfoRow["Section"] : 'Not available'; ?>
                </div>
                
            </div>
            <div class="row">
                <div style="font-family:'Arial Rounded MT';">
                        Email: <?php echo isset($studentInfoRow["Email"]) ? $studentInfoRow["Email"] : 'Not available'; ?>
                </div>
                
            </div>
        </div>
        <br>
        <form>
            <a href="CoreCheck.php" button class="btn-blue">NEXT</button></a>
        </form>
        <div class="row">
            <div >
                <section>
                    <br>
                    &copy; 2024 - OTAS 4.0
                </section>
            </div>
        </div>
    </div>
    
</body>
</html>