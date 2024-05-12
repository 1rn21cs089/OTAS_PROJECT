<?php
session_start();
if(isset($_SESSION['username'])){
}
else {
        echo '
<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            max-width: 600px;
            margin: auto;
            padding: 20px;
        }

        h2 {
            color: #333;
            font-size: 20px;
            margin-bottom: 20px;
        }

        #searchForm, #updateForm {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"], input[type="email"] {
            width: calc(100% - 40px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="submit"], button[type="button"] {
            width: 49%;
            padding: 10px;
            margin-top: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

            button[type="submit"]:hover, button[type="button"]:hover {
                background-color: #45a049;
            }

        #message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Search Student</h2>
    <form id="searchForm">
        <label for="usn">Enter USN:</label>
        <input type="text" id="usn" name="usn">
        <button type="submit">Search</button>
        <button type="button" onclick="clearFields()">Clear</button>

    </form>

    
    <form id="updateForm" style="display: none;">
    <h2>Student Information</h2>
       

        <button type="submit">Update</button>
    </form>

    <div id="message"></div>

    <script>


        function clearFields() {
            document.getElementById("searchForm").reset();
            document.getElementById("updateForm").innerHTML = '';
            document.getElementById("message").innerText = '';
        }

        document.getElementById("searchForm").addEventListener("submit", function (event) {
            event.preventDefault();
            var usn = document.getElementById("usn").value;

            fetch("get_student_data.php", {
                method: "POST",
                body: new URLSearchParams({
                    usn: usn
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data && data.USN) {
                        document.getElementById("updateForm").innerHTML = `
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" value="${data.First_Name}">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" value="${data.Last_Name}">
                            <label for="phone_number">Phone Number:</label>
                            <input type="text" id="phone_number" name="phone_number" value="${data.Phone_Number}">
                            <label for="sem">Semester:</label>
                            <input type="text" id="sem" name="sem" value="${data.Sem}">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="${data.Email}">
                            <label for="dept_id">Department ID:</label>
                            <input type="text" id="dept_id" name="dept_id" value="${data.Dept_Id}">
                            <label for="batch">Batch:</label>
                            <input type="text" id="batch" name="batch" value="${data.Batch}">
                            <label for="section">Section:</label>
                            <input type="text" id="section" name="section" value="${data.Section}">
                            <input type="hidden" id="usn" name="usn" value="${data.USN}">
                            <button type="submit">Update</button>
                        `;
                        document.getElementById("updateForm").style.display = "block";
                        document.getElementById("message").innerText = "";
                    } else {
                        document.getElementById("message").innerText = "USN not found";
                        document.getElementById("updateForm").style.display = "none";
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        document.getElementById("updateForm").addEventListener("submit", function (event) {
            event.preventDefault();
            var formData = new FormData(document.getElementById("updateForm"));

            fetch("update_student_data.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    document.getElementById("message").innerText = data;
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

</body>
</html>
