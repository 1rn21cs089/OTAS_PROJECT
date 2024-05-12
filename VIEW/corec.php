<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }

        table {
            width: 70%; 
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 2px solid black;
            padding: 10px;
            text-align: left;
        }

        .edit-input {
            display: none;
        }

        .edit-button {
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }

        .submit-button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php
session_start();
if (isset($_SESSION['username'])) {
    $usn = $_SESSION['username'];
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
        ORDER BY c.SubCode";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Subject Code</th><th>Subject Name</th><th>Teacher Name</th><th>Action</th></tr>';
            while ($row = $result->fetch_assoc()) {
                echo "<tr id='row-" . $row["SubCode"] . "'><td>" . $row["SubCode"] . "</td>";
                echo "<td id='subname-cell-" . $row["SubCode"] . "'>" . $row["SubName"] . "</td>";
                echo "<td id='teachername-cell-" . $row["SubCode"] . "'>" . $row["Teacher_FName"] . " " . $row["Teacher_LName"] . "</td>";
                echo "<td><span class='edit-button' onclick='editRow(\"" . $row["SubCode"] . "\")'>Edit</span></td></tr>";
                echo "<tr id='edit-row-" . $row["SubCode"] . "' class='edit-input' style='display:none;'><td>" . $row["SubCode"] . "</td>";
                echo "<td><select id='subname-" . $row["SubCode"] . "'>";
                
                $subnameResult = $conn->query("SELECT su.SubName FROM teacher_subcombo c JOIN subjects su ON su.SubCode = c.SubCode JOIN teacher t ON t.Tid = c.Tid JOIN student s ON s.Section = c.Section AND s.Sem = c.Sem WHERE c.Core = 1 AND c.Section = '$section' AND c.Sem = $sem AND s.USN LIKE '$usn'");
while ($subnameRow = $subnameResult->fetch_assoc()) {
    echo "<option value='" . $subnameRow["SubName"] . "'" . ($subnameRow["SubName"] == $row["SubName"] ? " selected" : "") . ">" . $subnameRow["SubName"] . "</option>";
}
                
                echo "</select></td>";
                echo "<td><select id='teachername-" . $row["SubCode"] . "'>";
                
                
                $teachernameResult = $conn->query("SELECT CONCAT(t.Teacher_FName, ' ', t.Teacher_LName) AS TeacherName FROM teacher_subcombo c JOIN subjects su ON su.SubCode = c.SubCode JOIN teacher t ON t.Tid = c.Tid JOIN student s ON s.Section = c.Section AND s.Sem = c.Sem WHERE c.Core = 1 AND c.Section = '$section' AND c.Sem = $sem AND s.USN LIKE '$usn'");
                while ($teachernameRow = $teachernameResult->fetch_assoc()) {
                    echo "<option value='" . $teachernameRow["TeacherName"] . "'" . ($teachernameRow["TeacherName"] == ($row["Teacher_FName"] . " " . $row["Teacher_LName"]) ? " selected" : "") . ">" . $teachernameRow["TeacherName"] . "</option>";
                }
                                
                echo "</select></td>";
                echo "<td><button onclick='saveEdit(\"" . $row["SubCode"] . "\")'>Save</button></td></tr>";
            }
            echo '</table>';
            echo '<button class="submit-button" onclick="submitEdits()">Submit All Edits</button>';
        } else {
            echo "0 results";
        }
    } else {
        echo "Session not started or username not set.";
    }

    $conn->close();
}
?>

<script>
    var editedData = {};

    function editRow(subcode) {
        document.getElementById('row-' + subcode).style.display = 'none';
        document.getElementById('edit-row-' + subcode).style.display = 'table-row';
    }

    function saveEdit(subcode) {
        var newSubcode = subcode; 
        var newSubname = document.getElementById('subname-' + subcode).value;
        var newTeachername = document.getElementById('teachername-' + subcode).value;
        
        editedData[subcode] = {
            subcode: newSubcode,
            subname: newSubname,
            teachername: newTeachername
        };
        
        document.getElementById('subname-cell-' + subcode).textContent = newSubname;
        document.getElementById('teachername-cell-' + subcode).textContent = newTeachername;
        
        document.getElementById('row-' + subcode).style.display = 'table-row';
        document.getElementById('edit-row-' + subcode).style.display = 'none';
    }

    function submitEdits() {
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "savecore.php");

        for (var subcode in editedData) {
            if (editedData.hasOwnProperty(subcode)) {
                for (var key in editedData[subcode]) {
                    if (editedData[subcode].hasOwnProperty(key)) {
                        var input = document.createElement("input");
                        input.setAttribute("type", "hidden");
                        input.setAttribute("name", "editedData[" + subcode + "][" + key + "]");
                        input.setAttribute("value", editedData[subcode][key]);
                        form.appendChild(input);
                    }
                }
            }
        }

        document.body.appendChild(form);
        form.submit();
    }
</script>

</body>
</html>
