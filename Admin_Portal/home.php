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
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Home</title>
</head>
<body>
    <header id="custom-header">
        <div class="custom-header-div">
            <div class="custom-image-div">
                <img id="custom-header-img" src="logo.png" alt="OTAS">
            </div>
            <nav id="custom-nav" class="custom-nav-di">
                <a class="custom-nav-link" href="#hero">Home</a>
                <a class="custom-nav-link" href="#About">About</a>
                <a class="custom-nav-link" href="#Team">Team</a>
                <a class="custom-nav-link" href="#Contact">Contact</a>
                <div class="dropdown">
                    <button onclick="toggleDropdown()" class="dropbtn">Password <i class="fa-solid fa-caret-down"></i></button>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="changepassword.php">Change Password</a>
                        <a href="forgotpassword.php">Forgot Password</a>
                    </div>
                </div>
    
                <div class="dropdown">
                    <button onclick="toggleDropdown()" class="dropbtn">Add <i class="fa-solid fa-caret-down"></i></button>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="addstudent.php">Add Student</a>
                        <a href="addteacher.php">Add Teacher</a>
                        <a href="addsubject.php">Add Subject</a>
                        <a href="addelective.php">Add Elective</a>
                        <a href="add_subject_combination.php">Add Subject Combination</a>
                    </div>
                </div>
                <div class="dropdown">
                    <button onclick="toggleDropdown()" class="dropbtn">Edit <i class="fa-solid fa-caret-down"></i></button>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="edit_student.html">Edit Student</a>
                        <a href="edit_teacher.html">Edit Teacher</a>
                        <a href="edit_subject.html">Edit Subject</a>
                        <a href="remove_elective.html">Remove Elective</a>
                        <a href="#">Reset Account</a>
                    </div>
                </div>
                <div class="dropdown">
                    <button onclick="toggleDropdown()" class="dropbtn">View <i class="fa-solid fa-caret-down"></i></button>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="view_sub_combo.html">Add Subject Combination</a>
                    </div>
                </div>
                <a class="custom-nav-link" href="#validate">Validate</a>
                <a class="custom-nav-link" href="#reports">Reports</a>
                <a class="custom-nav-link" href="#databases">Databases</a>
                <a class="custom-nav-link" href="logout.php">Logoff</a>
            </nav>
        </div>
        <script>
            function toggleDropdown() {
                var dropdownContent = document.getElementById("myDropdown");
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            }
        </script>
    </header>
    <section id="hero" class="hero" style="background-image: url(otas.jpg);">
        <div class="overlay">
            <h2>OTAS<br /><small>Online Teacher's Appraisal System</small></h2>
        </div>
    </section>

    <section id="About" class="section-padding">
        <div class="container">
            <div class="section-title text-center">
                <h1>About OTAS</h1>
                <span></span>
                <h4>We solve problems!</h4>
            </div>

            <div class="row text-center">
                <div class="col-md-3">
                    <div class="about-single">
                        <i class="fa fa-code"></i>
                        <h4>Technologies Used</h4>
                        <p>ASP.NET MVC, MySQL, Microsoft RDLC, Entity Framework 6, LINQ, HTML, CSS, JQuery, AJAX, Twitter Bootstrap 3.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="about-single">
                        <i class="fa fa-umbrella"></i>
                        <h4>Software Requirements</h4>
                        <p>Microsoft Visual Studio 2015, Microsoft SQL Server, IIS.</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="about-single">
                        <i class="fa fa-tablet"></i>
                        <h4>Report Generation</h4>
                        <p>Department Specific Report Generation and Teacher Wise Appraisal Aggregation.</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="about-single">
                        <i class="fa fa-eye"></i>
                        <h4>Beautifully Crafted</h4>
                        <p>Designed the software in accordance with its functionality, both logically and aesthetically.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="our-team" id="Team">
        <h1>Our Team</h1>
        <span></span>
        <div class="image-scroll-container" onmouseover="pauseAnimation()" onmouseout="resumeAnimation()">
            <div class="image-with-text">
                <img src="https://wallpapercave.com/wp/wp2611170.jpg" alt="1">
                <div class="overlay-text">Text for Image 1</div>
            </div>
            <div class="image-with-text">
                <img src="https://wallpapercave.com/wp/wp2611170.jpg" alt="2">
                <div class="overlay-text">Text for Image 2</div>
            </div>
            <div class="image-with-text">
                <img src="https://wallpapercave.com/wp/wp2611170.jpg" alt="3">
                <div class="overlay-text">Text for Image 3</div>
            </div>
            <div class="image-with-text">
                <img src="https://wallpapercave.com/wp/wp2611170.jpg" alt="1">
                <div class="overlay-text">Text for Image 1</div>
            </div>
            <div class="image-with-text">
                <img src="https://wallpapercave.com/wp/wp2611170.jpg" alt="2">
                <div class="overlay-text">Text for Image 2</div>
            </div>
            <div class="image-with-text">
                <img src="https://wallpapercave.com/wp/wp2611170.jpg" alt="3">
                <div class="overlay-text">Text for Image 3</div>
            </div>
        </div>

        <script>
            function pauseAnimation() {
                var container = document.querySelector('.image-scroll-container');
                container.style.animationPlayState = 'paused';
            }

            function resumeAnimation() {
                var container = document.querySelector('.image-scroll-container');
                container.style.animationPlayState = 'running';
            }
        </script>
    </section>
    <section class="Contact" id="Contact">
        <div class="contact">
            <h1>Contact Us</h1>
            <span></span>
            <h4>principal@rnsit.ac.in</h4>
        </div>
        <div class="maps">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3889.085937414627!2d77.51639331418941!3d12.902195419889809!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae3fa7243af9c3%3A0x9bed6669a38d1c3!2sRNS+Institute+of+Technology!5e0!3m2!1sen!2sin!4v1462809256856" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </section>

    <footer>
        <div class="container">
            <center><p>&copy; 2024 OTAS. All rights reserved.</p></center>
        </div>
    </footer>
</body>
</html>
