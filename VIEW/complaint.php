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
    <title>Our Services</title>
    <link rel="stylesheet" href="complaint.css" class="css">
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <div class="wrapper">
        <h1>COMPLAINT PORTAL</h1>
        <p>This portal provides a platform where you can raise the complaint regarding </p>
             <div class="content-box">
              <div class="card">
                <i class='bx bxs-user-x'></i>
                <h2>User Details Verification</h2>
                <p>Raise a complaint here regarding the User Information discrepancy.</p>
                <a href="userchec.php" class="btn btn-blue">CLICK HERE</a>
            </div>
                <div class="card">
                    <i class='bx bxs-book-reader'></i>
                    <h2>Core Subject Verification</h2>
                  <p>Raise a complaint here regarding the Core Subject discrepency.  </p>
                  <a href="corec.php" class="btn btn-blue">CLICK HERE</a>
                </div>
                
                <div class="card">
                    <i class='bx bxs-book-reader'></i>
                    <h2>Elective Subject Verification</h2>
                  <p>Raise a complaint here regarding the Elective Subject discrepency.  </p>
                  <a href="electivec.php" class="btn btn-blue">CLICK HERE</a>
                </div>
                <div class="card">
                    <i class='bx bx-laptop'></i>
                    <h2>Laboratory Subject Verification</h2>
                  <p>Raise a complaint here regarding the Laboratory Subject discrepency.  </p>
                  <a href="labc.php" class="btn btn-blue">CLICK HERE</a>
                </div>
             </div>
             <form action="logoff.php" method='get'>
              <button type='submit' class='btn btn-blue'>LOGOUT</button>
            </form>
    </div>
    

</body>

</html>