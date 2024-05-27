<?php
session_start();
if(isset($_SESSION['username'])){
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
<title>Edit Teacher</title>
<style>body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
    background-color: #f2f2f2;
}

h1 {
    color: #333;
}

form {
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="password"],
select {
    width: calc(100% - 20px);
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 10px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #45a049;
}

#errorMessage {
    margin-top: 10px;
    color: red;
}

#errorMessage,
#teacherFields {
    display: none;
}

#teacherFields {
    margin-top: 20px;
}

#teacherFields label {
    width: 150px;
    display: inline-block;
}

#teacherFields input[type="text"],
#teacherFields input[type="email"],
#teacherFields input[type="password"],
#teacherFields select {
    width: calc(100% - 160px);
}

#teacherFields button[type="submit"],
#teacherFields button[type="button"] {
    margin-top: 20px;
}
</style>
</head>
<body>
<h1>Edit Teacher</h1>
<form id="editTeacherForm" method="post" action="update_teacher.php">
    <label for="tid">Teacher ID:</label>
    <input type="text" id="tidInput" name="tid">
    <button type="button" onclick="searchTeacher()">Search</button>
    <br><br>
    <div id="teacherFields" style="display: none;">
        <label for="fname">First Name:</label>
        <input type="text" id="fnameInput" name="fname"><br>
        <label for="lname">Last Name:</label>
        <input type="text" id="lnameInput" name="lname"><br>
        <label for="deptId">Department ID:</label>
        <select id="deptIdSelect" name="deptId">
            <option value="">Select Department</option>
        </select><br>
        <label for="designation">Designation:</label>
        <input type="text" id="designationInput" name="designation"><br>
        <label for="email">Email:</label>
        <input type="email" id="emailInput" name="email"><br>
        <label for="password">Password:</label>
        <input type="password" id="passwordInput" name="password"><br>
        <button type="submit">Save Changes</button>
        <button type="button" onclick="clearFields()">Clear</button>
    </div>
    <div id="errorMessage" style="color: red; display: none;">Teacher ID not found.</div>
</form>

<script>
    
function populateDepartments(departments) {
    var deptSelect = document.getElementById("deptIdSelect");
    
    deptSelect.innerHTML = '<option value="">Select Department</option>';
    
    departments.forEach(function(dept) {
        var option = document.createElement("option");
        option.text = dept.DepName; 
        option.value = dept.DeptId;  
        deptSelect.add(option);
    });
}

    
    
    function fetchDepartments() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_departments.php", true); 
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var departments = JSON.parse(xhr.responseText);
                populateDepartments(departments);
            }
        };
        xhr.send();
    }
    
    
    window.onload = fetchDepartments;

    function searchTeacher() {
    var tid = document.getElementById("tidInput").value;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_teacher.php?tid=" + tid, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                populateFields(response.teacher);
                document.getElementById("teacherFields").style.display = "block";
                document.getElementById("errorMessage").style.display = "none";
            } else {
                document.getElementById("errorMessage").style.display = "block";
                document.getElementById("teacherFields").style.display = "none";
            }
        }
    };
    xhr.send();
}

function populateFields(teacher) {
    document.getElementById("fnameInput").value = teacher.Teacher_FName;
    document.getElementById("lnameInput").value = teacher.Teacher_LName;
    document.getElementById("designationInput").value = teacher.Designation;
    document.getElementById("emailInput").value = teacher.Email;
    document.getElementById("passwordInput").value = teacher.Password;

    
    var deptSelect = document.getElementById("deptIdSelect");
    for (var i = 0; i < deptSelect.options.length; i++) {
        if (deptSelect.options[i].value === teacher.DeptId) {
            deptSelect.options[i].selected = true;
            break;
        }
    }
}


function clearFields() {
    document.getElementById("editTeacherForm").reset();
    document.getElementById("teacherFields").style.display = "none";
    document.getElementById("errorMessage").style.display = "none";
}
</script>
</body>
</html>