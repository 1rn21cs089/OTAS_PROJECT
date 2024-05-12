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
<title>Elective Subjects</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 800px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    button {
        background-color: #4caf50;
        color: white;
        border: none;
        padding: 8px 16px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Elective Subjects</h2>
    <table id="electiveTable">
        <thead>
            <tr>
                <th>SubCode</th>
                <th>SubName</th>
                <th>Sem</th>
                <th>DeptId</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
    </table>
</div>

<script>
    
function displayElectiveSubjects() {
    fetch('fetch.php') 
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#electiveTable tbody');
            tableBody.innerHTML = '';

            data.forEach(subject => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${subject.SubCode}</td>
                    <td>${subject.SubName}</td>
                    <td>${subject.Sem}</td>
                    <td>${subject.DeptId}</td>
                    <td><button onclick="removeSubject('${subject.SubCode}')">Remove</button></td>
                `;
                tableBody.appendChild(row);
            });
        });
}
displayElectiveSubjects();

function removeSubject(subCode) {
    fetch('remove.php?SubCode=' + subCode, { method: 'DELETE' }) 
        .then(response => {
            if (response.ok) {
                
                displayElectiveSubjects();
            } else {
                console.error("Error removing subject");
            }
        })
        .catch(error => console.error("Error removing subject:", error));
}





</script>

</body>
</html>
