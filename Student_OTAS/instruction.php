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
    $sql = "SELECT * FROM student WHERE USN='$usn'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $student_name = htmlspecialchars($row["First_Name"]) . " " . htmlspecialchars($row["Last_Name"]);
        $class_section = htmlspecialchars($row["Sem"]) . "-" . htmlspecialchars($row["Section"]);
    }
    $sql_subjects = "SELECT subjects.SubCode, subjects.SubName, subjects.lab, subjects.Elective, teacher.Teacher_FName, teacher.Teacher_LName, teacher.Tid
                 FROM subjects 
                 INNER JOIN teacher_subcombo ON subjects.SubCode = teacher_subcombo.SubCode 
                 INNER JOIN teacher ON teacher_subcombo.Tid = teacher.Tid 
                 WHERE teacher_subcombo.DeptId = '{$row['Dept_Id']}' AND teacher_subcombo.Sem = '{$row['Sem']}' AND teacher_subcombo.Section = '{$row['Section']}'
                 ORDER BY teacher_subcombo.SubCode";
    $result_subjects = $conn->query($sql_subjects);
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSTRUCTION PAGE</title>
    <style>
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

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
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

        body {
            background-image: url("instruction.jpeg");
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
            margin: 0; 
            font-family: 'Helvetica', sans-serif;
            font-weight: bold;
        }

        .mainContent {
            color: black;
            background: rgba(255, 255, 255, 0.816);
            margin-top: 50px;
            padding: 20px; 
        }

        .scale-in, .fade-In-Left, .fade-in-right {
            margin-bottom: 20px; 
        }

        ul {
            list-style-type: upper-roman;
            padding: 25;
            text-align: left; 
        }

        li {
            margin: 10px;
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
            background-color: #456cae; 
        }
    </style>
</head>
<body>
    <div class="mainContent">
        <center>
            <div class="fade-In-Left">
                <h2>Instructions</h2>
            </div>
    
            <div class="fade-In-Left">
                <p>(Please read)</p>
            </div>
    
        </center>
       
        <hr color="black"/>

        <ul style="line-height: 30px; font-size: 20px;">
            <li class="fade-In-Left">
                This is an appraisal, not a vengeance. Please fill up accordingly.
            </li>
            <li class="fade-in-right">
                Keep your suggestions to bullet points; an essay would do no good.
            </li>
            <li class="fade-In-Left">
                Also, your appraisal is called "yours" for a reason. Let your own opinions and logic triumph today.
            </li>
            <li class="fade-in-right">
                Appraisals are a litmus test, and we want the truth. We'd appreciate if everybody filled only their own questions.
            </li>
            <li class="fade-In-Left">
                May the force be with you, young Padawan.
            </li>
        </ul>
        <br />

        <div class="form-group">
            <div class="fade-In-Left">
                <?php
                if ($result_subjects && $result_subjects->num_rows > 0) {
                    $row_subject = $result_subjects->fetch_assoc();
                    $subject_name = htmlspecialchars($row_subject["SubName"]);
                    $lab = $row_subject["lab"];
                    $elective = $row_subject["Elective"];
                    $subject_code = $row_subject["SubCode"];
                    $teacher_name = htmlspecialchars(urldecode($row_subject["Teacher_FName"])) . " " . htmlspecialchars(urldecode($row_subject["Teacher_LName"]));
                    $teacher_id = $row_subject["Tid"];
                    $type = ($lab == 1) ? "lab" : (($elective == 1) ? "elective" : "core");
                    echo '<form action="subject_questions.php" method="get">';
                    echo '<input type="hidden" name="subcode" value="' . urlencode($subject_code) . '">';
                    echo '<input type="hidden" name="subject" value="' . $subject_name . '">';
                    echo '<input type="hidden" name="type" value="' . urlencode($type) . '">';
                    echo '<input type="hidden" name="teacher" value="' . htmlspecialchars($teacher_name) . '">';
                    echo '<input type="hidden" name="usn" value="' . urlencode($usn) . '">';
                    echo '<input type="hidden" name="tid" value="' . urlencode($teacher_id) . '">';
                    echo '<input type="hidden" name="sem" value="' . urlencode($row['Sem']) . '">';
                    echo '<input type="hidden" name="section" value="' . urlencode($row['Section']) . '">';
                    echo '<input type="submit" value="Proceed" class="btn btn-primary"/>';
                    echo '</form>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
