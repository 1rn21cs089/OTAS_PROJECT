<?php
session_start();
if(isset($_SESSION['username'])){

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otas";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->close();
}
else{
 echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.php");}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>FEEDBACK PAGE</title>
    <style>
        body {
            background: url("feedback.jpg") repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            color: rgb(255, 255, 255);
            font-family: 'Helvetica', sans-serif;
            font-weight: bold;
        }
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .fade-In-Left{
            animation: fadeInLeft 2s ease;
        }
        .fade-in-right{
            animation: fadeInRight 2s ease;
        }
        input[type="submit"] {
                        background-color: rgb(0, 157, 255); 
                        color: white;
                        padding: 10px 20px; 
                        font-size: 16px; 
                        font-weight: bold;
                        border: none; 
                        border-radius: 5px; 
                        cursor: pointer; 
                        }
                        input[type="submit"]:hover {
                            background-color: #2d7ac2; 
                        }
    </style>
</head>

<body>
    <div class="container">
        <div class="fade-In-Left">
            <center><h2>Feedbacks</h2></center>
        </div>
        <hr />

        <form action="feedback1.php" method="post">
            <br />
            <div class="fade-In-Left">
                <b>Provide your Feedbacks.</b><br /><br />
            </div>

            <div class="fade-in-right">
                <textarea id="General" rows="8" cols="80" style="max-width:700px" class="form-control" name="General"></textarea>
            </div>

            <br /><br />
            <div class="fade-In-Left">
                <b>Would you like to share your experience about the website ?</b><br /><br />
            </div>

            <div class="fade-in-right">
                <textarea id="OTAS" rows="8" cols="80" style="max-width:700px" class="form-control" name="OTAS"></textarea>
            </div>

            <br /><br />
            <div class="form-group">
                <div class="fade-In-Left">
                    <input type="submit" value="Submit" class="btn btn-primary" />
                </div>
            </div>
        </form>
    </div>
</body>
</html>
