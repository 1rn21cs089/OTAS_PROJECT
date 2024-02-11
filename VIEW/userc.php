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
    <title>User Details Check</title>
    <style>
        .container {
            text-align: center;
        }
        .column {
            display: inline-block;
            width: 45%;
            vertical-align: top;
        }
        h1 {
            text-align: center;
        }
        h2 {
            text-align: center;
        }

        .column1, .column {
            background-color: #ecf0f1;
            padding: 20px;
            font-size:18px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
            width: 400px;
            height: 400px;
            margin: 0 20px;
        }

        .column1 {
            margin-right: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Details Check</h1>
        <h2>If any discrepancy is found in the User Details, fill its respective field with the correct value.</h2>
        <br>
        <div class="column">
            <div class="row">
                <div style="font-family:'Arial Rounded MT';">
                    USN: <?php echo isset($studentInfoRow["USN"]) ? $studentInfoRow["USN"] : 'Not available'; ?>
                </div>
                <br><br>
            </div>
            <div class="row">
                <div style="font-family:'Arial Rounded MT';">
                    First Name: <?php echo isset($studentInfoRow["First_Name"]) ? $studentInfoRow["First_Name"] : 'Not available'; ?> 
                </div>
                <br><br>
            </div>
            <div class="row">
                <div style="font-family:'Arial Rounded MT';">
                    Last Name: <?php echo isset($studentInfoRow["Last_Name"]) ? $studentInfoRow["Last_Name"] : ''; ?>
                </div>
                <br><br>
            </div>
            <div class="row">
                <div style="font-family:'Arial Rounded MT';">
                    Semester: <?php echo isset($studentInfoRow["Sem"]) ? $studentInfoRow["Sem"] : 'Not available'; ?>
                </div>
                <br><br>
            </div>
            <div class="row">
                <div style="font-family:'Arial Rounded MT';">
                    Section: <?php echo isset($studentInfoRow["Section"]) ? $studentInfoRow["Section"] : 'Not available'; ?>
                </div>
                <br><br>
            </div>
            <div class="row">
                <div style="font-family:'Arial Rounded MT';">
                    Email: <?php echo isset($studentInfoRow["Email"]) ? $studentInfoRow["Email"] : 'Not available'; ?>
                </div>
                <br><br>
            </div>
        </div>

        <div class="column">
            <form action="save.php" method="post">
                <div class="row">
                    <div style="font-family:'Arial Rounded MT';">
                        USN: <input type="text" id="corrected_usn" name="corrected_usn">
                    </div><br><br>
                </div>
                <div class="row">
                    <div style="font-family:'Arial Rounded MT';">
                        First Name: <input type="text" id="fname" name="fname">
                    </div><br><br>
                </div>
                <div class="row">
                    <div style="font-family:'Arial Rounded MT';">
                       Last Name: <input type="text" id="lname" name="lname">
                    </div><br><br>
                </div>
                <div class="row">
                    <div style="font-family:'Arial Rounded MT';">
                        Semester: <input type="text" id="semester" name="semester">
                    </div><br><br>
                </div>
                <div class="row">
                    <div style="font-family:'Arial Rounded MT';">
                        Section: <input type="text" id="section" name="section">
                    </div><br><br>
                </div>
                <div class="row">
                    <div style="font-family:'Arial Rounded MT';">
                        Email: <input type="email" id="email" name="email">
                    </div><br><br>
                </div>
                
                <button type="submit" id="saveButton">Save</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById("saveButton").addEventListener("click", function() {
           
            alert("User details saved successfully!");
        
            window.location.href = "complaint.html";
        });
    </script>
    
</body>
</html>
