<?php
session_start();
if(isset($_SESSION['username'])){
}
else {
        echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 1050px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 6px; 
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
    }
    .dropdown {
        position: absolute;
        display: inline-block;
        margin-left: -28px;
        margin-top: -20px;
    }
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        z-index: 1;
    }
    .dropdown:hover .dropdown-content {
        display: block;
    }
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }
    .dropdown-content a:hover {
        background-color: #ddd;
    }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">OTAS</a>
        <a class="navbar-brand" href="home.php">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <nav class="navbar">
                    <ul class="nav-list">
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">COMPLAINT</a>
                            <div class="dropdown-content">
                                <a href="portal_complaint.php">USER</a>
                                <a href="corecomp.php">CORE</a>
                                <a href="eleccomp.php">ELECTIVE</a>
                                <a href="labcomp.php">LABORATORY</a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </ul>
        </div>
        <div class="navbar-text ms-auto">
            <a href="#">Log Off</a>
        </div>
    </div>
</nav>
<div class="container">
    <h1>ELECTIVE SUBJECT COMPLAINT</h1>
    <table>
        <thead>
            <tr>
                <th>USN</th>
                <th>SUBCODE</th>
                <th>SUBJECT NAME</th>
                <th>TEACHER NAME</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "otas";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "SELECT * FROM electivecheck ";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["usn"]."</td>";
                echo "<td>".$row["subcode"]."</td>";
                echo "<td>".$row["subname"]."</td>";
                echo "<td>".$row["teachername"]."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found</td></tr>";
        }
        
        $conn->close();
        ?>
        </tbody>
    </table>
    <form method="POST" action="">
        <button type="submit" name="clear_responses" class="btn btn-danger mt-3">Clear Responses</button>
    </form>
    <?php
    if (isset($_POST['clear_responses'])) {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "TRUNCATE TABLE electivecheck";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("All responses cleared successfully.");</script>';
            echo '<script>window.location.href = "home.php";</script>';
        } else {
            echo "Error: " . $conn->error;
        }
        $conn->close();
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-EVSTQN3/azjAEIK2y6k4Upomg9KM7iqkIRqLsl5dF8Pdrft9z3/cx5S+4+9f5Tbi" crossorigin="anonymous"></script>
</body>
</html>
