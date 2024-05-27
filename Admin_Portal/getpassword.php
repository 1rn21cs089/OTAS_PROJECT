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
    <title>Get Password</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input[type="text"] {
            width: 250px;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        form button {
            padding: 10px 20px;
            background-color: green;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: green;
        }

        #error-message {
            text-align: center;
            color: red;
            margin-bottom: 20px;
        }

        #password-result {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff; 
        }

        @media (max-width: 600px) {
            form input[type="text"] {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <h2>Get Password</h2>
    <form id="getPasswordForm">
        <label for="usn">Enter USN:</label><br>
        <input type="text" id="usn" name="usn" required><br><br>
        <button type="submit">Get Password</button>
        <button type="button" onclick="clearInput()">Refresh</button>
    </form>
    <div id="password-result"></div> 
    
    <script>
        $(document).ready(function() {
            $("#getPasswordForm").submit(function(event) {
                event.preventDefault(); 

                var usn = $("#usn").val();
                $.ajax({
                    url: "getpasswords.php",
                    type: "GET",
                    data: { usn: usn },
                    dataType: "json",
                    success: function(response) {
                        if(response.success) {
                            $("#password-result").html("Password for USN " + usn + " is: " + response.password); // Corrected ID to match CSS
                        } else {
                            $("#password-result").html(response.message); 
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        function clearInput() {
            $("#usn").val("");
            $("#password-result").empty(); 
        }
    </script>
</body>
</html>
