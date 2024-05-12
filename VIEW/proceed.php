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
    <title>PROCEED</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            justify-content: space-around;
        }

        .column {
            background-color: #ecf0f1;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 385.47px; 
            margin-right: 80px; 
        }

        .column:last-child {
            margin-right: 0;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="column">
            <p>If you find any discrepancy in your data, CLICK HERE</p>
            <a href="complaint.php"><button>RAISE A COMPLAINT</button></a>
        </div>

        <div class="column">
            <p>Continue to LOG OUT</p>
            <a href="logoff.php"><button>LOG OUT</button></a>
        </div>
    </div>

</body>
</html>
