<?php
session_start();
if(isset($_SESSION['username'])){
    $usn=$_SESSION['username'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otas";

    $conn = new mysqli($servername,$username, $password, $dbname);

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
} 
else {
        echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details Verification OTAS</title>
    <style>
        @keyframes fadeInAnimation {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .col-md-10 {
            padding-left: 20px;
        }

        body {
            opacity: 0;
            animation: fadeInAnimation 2s ease-in-out forwards;
            background-image: url("detailsverification.jpg");
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
    </style>
</head>
<body id="for_body">
    <div class="wow fadeIn Page" style="padding:20px;width: 80%;background: rgba(54, 25, 25, 0.4);border-radius: 10px;">
        <h4 style="font-family:'Arial Rounded MT';">Your Details</h4>
        <hr>
        <div class="Student-Details">
            <div class="row">
                <div style="font-family:'Arial Rounded MT';">
                    Name:
                    <?php echo $studentInfoRow["First_Name"]; ?> <?php echo $studentInfoRow["Last_Name"]; ?>
                </div>
            </div>
            <div class="row">
                <div style="font-family:'Arial Rounded MT';flex: 0 0 16.666667%; ">
                    Department:
                    <?php
        if (isset($studentInfoRow["Dept_Id"])) {
            $deptId = $studentInfoRow["Dept_Id"];
            $deptQuery = "SELECT DepName FROM department WHERE DeptId = ?";
            $stmt = $conn->prepare($deptQuery);

            if ($stmt) {
                $stmt->bind_param("s", $deptId);
                $stmt->execute();
                $deptResult = $stmt->get_result();

                if ($deptResult->num_rows > 0) {
                    $deptRow = $deptResult->fetch_assoc();
                    echo $deptRow["DepName"];
                } else {
                    echo 'Not Available';
                }

                $stmt->close();
            }
        } else {
            echo 'N/A';
        }
        ?>
                </div>
            </div>
            <div class="row">
                <div style="font-family:'Arial Rounded MT';flex: 0 0 16.666667%;">
                    Semester:
                    <?php echo $studentInfoRow["Sem"]; ?>
                </div>
            </div>
            <div class="row">
                <div style="font-family:'Arial Rounded MT';flex: 0 0 16.666667%; ">
                    Section:
                    <?php echo $studentInfoRow["Section"]; ?>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div>
                <section id="loginForm">
                    <h4 style="font-family:'Arial Rounded MT';">Please fill up your contact details</h4>
                    <div class="text-danger">
                  
                    </div>
                    <form action="details.php" method="POST">
                        <div>
                            <div style="font-family:'Arial Rounded MT';" class="col-md-10">
                                <label style="flex: 0 0 16.666667%; " for="PRIMARY_CONTACT" class="col-md-2 control-label">
                                    Mobile &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input style="border-radius: 10px;height: 25px;width: 300px;" type="text" id="PRIMARY_CONTACT" class="form-control" autocomplete="off" required="required" name="mobile">
                                </label>
                                <div class="text-danger">
               
                                </div>
                            </div>
                        </div><br>
                        <div>
                            <div style="font-family:'Arial Rounded MT';flex: 0 0 16.666667%; " class="col-md-10">
                                <label style="flex: 0 0 16.666667%; " for="EMail" class="col-md-2 control-label">
                                    E-mail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input style="width: 300px;height: 25px;border-radius: 10px;" type="email" id="EMail" class="form-control" autocomplete="off" required="required" name="email">
                                </label>
                                <div class="text-danger">
                                </div>
                            </div>
                        </div>
                        <style>
                            input[type="submit"] {
                                background-color: rgb(76, 168, 175);
                                color: white;
                                padding: 10px 20px;
                                font-size: 16px;
                                border: none;
                                border-radius: 5px;
                                cursor: pointer;
                            }

                                input[type="submit"]:hover {
                                    background-color: #4b45a0;
                                }
                        </style><br>
                        <p>
                            <div style="flex: 0 0 100%; max-width: 100%;" class="form-group">
                                <div class="col-md-offset-2 col-md-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input style="border-radius: 10px;" type="submit" value="Submit" class="btn btn-primary">
                                </div>

                            </div>
                        </p>
                    </form>
                    <br><br>
                    <hr>
                    &copy; 2024 - OTAS 4.0
                </section>
            </div>
        </div>
    </div>
</body>
</html>