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
    <title>Get Passwords</title>
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
    .edit{
        display: flex;
    flex-direction: column;
    justify-content: center;
    width:50%;

    }
   

    </style>
</head>
<body>

    <center><h2>Get Password</h2></center>
    <div class="box">
    <div class="content">
        <form id="Form" action="download_passwords.php" method="post">
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
        $query = "SELECT DISTINCT Sem FROM student";
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
        $query = "SELECT DISTINCT Section FROM student";
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
    <button type="submit">Submit</button>
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
        });
</script>
    </div>
    

