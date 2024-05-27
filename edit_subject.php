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
<title>Edit Subject</title>
<style>
    body {
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
    #subjectFields {
        display: none;
    }
    
    #subjectFields {
        margin-top: 20px;
    }
    
    #subjectFields label {
        width: 150px;
        display: inline-block;
    }
    
    #subjectFields input[type="text"],
    #subjectFields input[type="email"],
    #subjectFields input[type="password"],
    #subjectFields select {
        width: calc(100% - 160px);
    }
    
</style>
</head>
<body>
<center><h1>Edit Subject</h1><center>
<form id="editSubjectForm" method="post" action="update_subject.php">
    <label for="subCode">Subject Code:</label>
    <input type="text" id="subCodeInput" name="subCode">
    <button type="button" onclick="searchSubject()">Search</button>
    <br><br>
    <div id="subjectFields" style="display: none;">
        <label for="subName">Subject Name:</label>
        <input type="text" id="subNameInput" name="subName"><br>
        <label for="sem">Semester:</label>
        <input type="text" id="semInput" name="sem"><br>
        <label for="elective">Elective:</label>
        <input type="text" id="electiveInput" name="elective"><br>
        <label for="deptId">Department:</label>
        <select id="deptIdSelect" name="deptId">
           
        </select><br>
        <button type="submit">Save Changes</button>
        <button type="button" onclick="clearFields()">Clear</button>
    </div>
    <div id="errorMessage" style="color: red; display: none;">Subject not found.</div>
</form>

<script>

    function populateDepartments(departments) {
        var deptSelect = document.getElementById("deptIdSelect");
        
        deptSelect.innerHTML = '<option value=""></option>';
        
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
    
function searchSubject() {
    var subCode = document.getElementById("subCodeInput").value;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_subject.php?subCode=" + subCode, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                populateFields(response.subject);
                document.getElementById("subjectFields").style.display = "block";
                document.getElementById("errorMessage").style.display = "none";
            } else {
                document.getElementById("errorMessage").style.display = "block";
                document.getElementById("subjectFields").style.display = "none";
            }
        }
    };
    xhr.send();
}

function populateFields(subject) {
    document.getElementById("subNameInput").value = subject.SubName;
    document.getElementById("semInput").value = subject.Sem;
    document.getElementById("electiveInput").value = subject.Elective;
    document.getElementById("deptIdSelect").value = subject.DeptId;
}

function clearFields() {
    document.getElementById("editSubjectForm").reset();
    document.getElementById("subjectFields").style.display = "none";
    document.getElementById("errorMessage").style.display = "none";
}
</script>
</body>
</html>
