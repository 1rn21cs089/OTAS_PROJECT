<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Teacher Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">OTAS</a>
        <a class="navbar-brand" href="#">Home</a>
        <a class="navbar-brand" href="dep_t.php">Add Teacher</a>
        <a class="navbar-brand" href="details.php">Class Details</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logoff.php">LOG OFF</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="content">
    <h2>CLASS TEACHER DETAILS</h2><br><br>
    <form id="teacherForm">
        <label for="Semester">Semester:</label>
        <select id="Semester" name="Semester">
            <option value="">Select Semester</option>
            <?php
            
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "otas";
            $conn = new mysqli($servername, $username, $password, $dbname);

            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            
            $sql = "SELECT DISTINCT Sem FROM student ORDER BY Sem ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['Sem'] . "'>" . $row['Sem'] . "</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="Section">Section:</label>
        <select id="Section" name="Section" disabled>
            <option value="">Select Section</option>
        </select><br>

        <input type="submit" value="Submit">
    </form>

    <div id="teacherDetails" style="display: none;">
        <h3><center>Teacher Details</center></h3><br>
        <table class="table">
            <thead>
                <tr>
                    <th>Teacher Name</th>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Electives</th>
                </tr>
            </thead>
            <tbody id="teacherDetailsBody">
            </tbody>
        </table>
    </div>
</div>
<br><br>
<section class="copyright">
    <div class="container">
        <p> &copy; 2024 - OTAS 4.0</p>
    </div>
</section>
<style>
    .content {
        margin-left: 5%;
        margin-top: 2%;
    }

    h2 {
        color: black;
    }

    label {
        display: inline-block;
        width: 100px;
        text-align: right;
        margin-right: 10px;
    }

    select {
        width: 150px;
    }

    input[type="submit"] {
        margin-left: 110px;
        margin-top: 10px;
    }

    .form-container {
        display: flex;
        justify-content: space-between;
    }

    #teacherDetails {
    border:  collapse ;
    width: 55%;
    position: absolute;
    top: 90px; 
    right: 5%; 
    
}

</style>

<script>
    
    document.getElementById("Semester").addEventListener("change", function() {
        var semesterValue = this.value;
        var sectionDropdown = document.getElementById("Section");

        
        sectionDropdown.disabled = false;

        
        sectionDropdown.innerHTML = "";

        
        var defaultOption = document.createElement("option");
        defaultOption.text = "Select Section";
        sectionDropdown.add(defaultOption);

        
        fetchSections(semesterValue);
    });

    function fetchSections(semester) {
        var sectionDropdown = document.getElementById("Section");

        
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var sections = JSON.parse(xhr.responseText);
                    sections.forEach(function(section) {
                        var option = document.createElement("option");
                        option.value = section;
                        option.text = section;
                        sectionDropdown.add(option);
                    });
                } else {
                    console.error("Error fetching sections");
                }
            }
        };
        xhr.open("GET", "fetch_sections.php?semester=" + semester, true);
        xhr.send();
    }

    
    document.getElementById("teacherForm").addEventListener("submit", function(event) {
        event.preventDefault(); 
        var semester = document.getElementById("Semester").value;
        var section = document.getElementById("Section").value;

        
var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
            var teacherDetails = JSON.parse(xhr.responseText);
            displayTeacherDetails(teacherDetails);
        } else {
            console.error("Error fetching teacher details");
        }
    }
};
xhr.open("GET", "fetch_teacher_details.php?semester=" + semester + "&section=" + section, true);
xhr.send();
});


function displayTeacherDetails(teacherDetails) {
    var tbody = document.getElementById("teacherDetailsBody");
    tbody.innerHTML = ""; 

    
    teacherDetails.forEach(function(teacher) {
        var row = document.createElement("tr");
        row.innerHTML = "<td>" + teacher.Teacher_FName + " " + teacher.Teacher_LName + "</td>" +
                        "<td>" + teacher.SubCode + "</td>" +
                        "<td>" + teacher.SubName + "</td>" +
                        "<td>" + teacher.Electives+ "</td>";

        tbody.appendChild(row);
    });

    
    document.getElementById("teacherDetails").style.display = "block";
}

</script>
</body>
</html>
