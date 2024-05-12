<?php
session_start();
if(isset($_SESSION['username'])){
    $mysqli = new mysqli("localhost", "root", "", "otas");

        if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
        }
}
else {
        echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Sub Combo</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
   .box {
    display: flex;
    justify-content: space-evenly;
    padding: 20px;
}

.content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    flex: 0 1 30%; 
}

.row {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

label {
    margin-right: 10px;
    min-width: 100px; 
}

select {
    flex: 1;
    padding: 8px;
    width: auto;
}

button {
    padding: 10px 20px;
    background-color: #4CAF50;
    width:100%;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}
table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        text-align: center;
        border-right: 1px solid #ddd;
    }
    th:last-child, td:last-child {
        border-right: none; 
    }
    th {
        background-color: #f2f2f2; 
    }
    tr:hover {
        background-color: #f5f5f5; 
    }
    th:nth-child(3), 
    td:nth-child(3) {
        width: 25%; 
    }
    th:nth-child(4),
    td:nth-child(4),
    td:nth-child(5) {
        width: 10%; 
    }
   .edit {
        font-family: Arial, sans-serif;
        width: 500px;
        margin-left:20px;
    }
    .econtent {
        padding: 20px;
    }
    .erow {
        margin-bottom: 15px;
    }
    .erow label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .erow select,
    .erow input[type="text"] {
        width: calc(100% - 12px); 
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .erow button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    .erow button:hover {
        background-color: #0056b3;
    }
   

    </style>
</head>
<body>

    <center><h2>View Subject Combination</h2></center>
    <div class="box">
    <div class="content">
        <form id="Form" action="" method="post">
    <div class="row">
    <label for="branch">Branch</label>
    <select id="branch" name="branch" onchange="enableNextField('branch', 'sem')">
    <option value="">Select</option>
        <?php
        $query = "SELECT DISTINCT DeptId FROM department";
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $stmt->bind_result($branch);

        while ($stmt->fetch()) {
        echo "<option value=\"$branch\">$branch</option>";
        }

        $stmt->close();
        ?>
    </select>
    </div>
    <br>
    <div class="row">
    <label for="sem">Semester</label>
    <select id="sem"  name="sem" disabled onchange="enableNextField('sem', 'sec')">
    <option value="">Select</option>
        <?php
        $query = "SELECT DISTINCT Sem FROM subjects";
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $stmt->bind_result($sem);

        while ($stmt->fetch()) {
        echo "<option value=\"$sem\">$sem</option>";
        }

        $stmt->close();
        ?>
    </select>
    </div>
    <br>
    <div class="row">
    <label for="sec">Section</label>
    <select id="sec" name="sec" disabled>
    <option value="">Select</option>
        <?php
        $query = "SELECT DISTINCT Section FROM teacher_subcombo";
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $stmt->bind_result($sec);

        while ($stmt->fetch()) {
        echo "<option value=\"$sec\">$sec</option>";
        }

        $stmt->close();
        
        ?>
    </select>
    </div>
    <br>
    <button id="searchBtn">Search</button>
    <br><br>
    <button type="reset" id="resetBtn">Reset</button>
    </form>

    <script>
function enableNextField(currentFieldId, nextFieldId) {
  var currentField = document.getElementById(currentFieldId);
  var nextField = document.getElementById(nextFieldId);
  
  if (currentField.value !== "") {
    nextField.disabled = false;
  } else {
    nextField.disabled = true;
  }
}
document.getElementById("resetBtn").addEventListener("click", function() {
            document.getElementById("branch").disabled = false;
            document.getElementById("sem").disabled = true;
            document.getElementById("sec").disabled = true;
            document.getElementById("result").style.display = "none";
        });
</script>
    </div>
    
<div id="result"></div>
</div>

<script>
$(document).ready(function() {
    $('#searchBtn').click(function() {
         event.preventDefault();
         $('#branch').prop('disabled', true);
        $('#sem').prop('disabled', true);
        $('#sec').prop('disabled', true);
        var branch = $('#branch').val();
        var sem = $('#sem').val();
        var sec = $('#sec').val();

        $.ajax({
            url: 'retrieve_details.php',
            type: 'POST',
            data: { branch: branch, sem: sem, sec: sec },
            success: function(response) {
                $('#result').html(response);
                $('#result').css('display', 'block');
            }
        });
    });
});
</script>

<div class="edit">
<div class="econtent">
<form id="editForm" style="display: none;" method="post" action="" >
    <input type="hidden" id="comboid" name="comboid">
     <div class="erow">
    <label for="teacherName">Teacher Name:</label>
    <select name="teacherName" id="teacherName"><br>
        <?php
        $query = "SELECT DISTINCT CONCAT_WS(' ', t.Teacher_FName, t.Teacher_LName)from teacher t";
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $stmt->bind_result($tn);

        while ($stmt->fetch()) {
        echo "<option value=\"$tn\">$tn</option>";
        }

        $stmt->close();
        ?>
    </select>
    </div>
    <div class="erow">
    <label for="teacherDepartment">Teacher's Department:</label>
    <select name="teacherDepartment" id="teacherDepartment"><br>
        <?php
        $query = "SELECT DISTINCT DeptId FROM department";
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $stmt->bind_result($branch);

        while ($stmt->fetch()) {
        echo "<option value=\"$branch\">$branch</option>";
        }

        $stmt->close();
        ?>
    </select>
    </div>
     <div class="erow">
     <label for="subjectCode">Subject Code:</label>
    <select name="subjectCode" id="subjectCode"><br>
        <?php
        $query = "SELECT DISTINCT SubCode FROM subjects";
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $stmt->bind_result($sc);

        while ($stmt->fetch()) {
        echo "<option value=\"$sc\">$sc</option>";
        }

        $stmt->close();
        ?>
    </select>
    </div>
    <div class="erow">
    <label for="subjectName">Subject Name:</label>
    <select name="subjectName" id="subjectName"><br>
        <?php
        $query = "SELECT DISTINCT SubName FROM subjects where SubName IS NOT NULL AND SubName != ''";
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $stmt->bind_result($sn);

        while ($stmt->fetch()) {
        echo "<option value=\"$sn\">$sn</option>";
        }

        $stmt->close();
        ?>
    </select>
    </div>
    
    <div class="erow">
    <label for="subjectDepartment">Subject Department:</label>
    <select name="subjectDepartment" id="subjectDepartment"><br>
        <?php
        $query = "SELECT DISTINCT DeptId FROM department";
        $stmt = $mysqli->prepare($query);
        $stmt->execute();
        $stmt->bind_result($branch);

        while ($stmt->fetch()) {
        echo "<option value=\"$branch\">$branch</option>";
        }

        $stmt->close();
        $mysqli->close();
        ?>
    </select>
    </div>
   
    <button type="button" id="saveChangesBtn">Save Changes</button>
</form>
</content>
</div>

</body>
</html>

