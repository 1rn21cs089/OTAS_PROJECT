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
        <a class="navbar-brand" href="home.php">Home</a>
        <a class="navbar-brand" href="Department_Report.php">Department Report</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="content">
    <h2>CLASS TEACHER DETAILS</h2><br><br>
   

    <form id="teacherForm">
        <label for="Tid">Teacher ID:</label>
        <input type="text" id="Tid" name="Tid">
        <br><br>
        <input type="submit" value="Submit">
    </form>

    <div id="teacherDetails" style="display: none;">
        <h2><center>Teacher Details</center></h2><br>
        <div id="teacherFullName" style="display: none;">
        
    </div>
        <table class="table">
            <thead>
                <tr>
                   
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Report</th>
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

    input[type="submit"] {
        margin-left: 110px;
        margin-top: 10px;
    }

    #teacherDetails {
        border-collapse: collapse;
        width: 55%;
        position: absolute;
        top: 150px; 
        right: 5%; 
    }

</style>

<script>
    document.getElementById("teacherForm").addEventListener("submit", function(event) {
        event.preventDefault(); 
        var tid = document.getElementById("Tid").value;

        
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
        xhr.open("GET", "fetch_teacher_details1.php?Tid=" + tid, true);
        xhr.send();
    });

    function displayTeacherDetails(teacherDetails) {
        var teacherFullNameDiv = document.getElementById("teacherFullName");
        var teacherDetailsDiv = document.getElementById("teacherDetails");
        var tbody = document.getElementById("teacherDetailsBody");
        tbody.innerHTML = ""; 

       
        teacherFullNameDiv.innerHTML = "<h3><center>" + teacherDetails[0].TeacherFullName + "</center></h3><br>";
        teacherFullNameDiv.style.display = "block";

        
        teacherDetails.forEach(function(teacher) {
            var row = document.createElement("tr");
            row.innerHTML = 
                            "<td>" + teacher.SubCode + "</td>" +
                            "<td>" + teacher.SubName + "</td>" +
                            "<td><a href='report1.php?sem=" + encodeURIComponent(teacher.Semesters) +
                            "&subCode=" + encodeURIComponent(teacher.SubCode) +
                            "&tid=" + encodeURIComponent(teacher.Tid) + "'>Report</a></td>";
            tbody.appendChild(row);
        });

        
        teacherDetailsDiv.style.display = "block";
    }
</script>
</body>
</html>
