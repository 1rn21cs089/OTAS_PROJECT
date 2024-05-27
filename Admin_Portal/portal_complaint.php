<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otas";

if (!isset($_SESSION['username'])) {
    echo '<script>alert("Please login to continue.");</script>';
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['clear_responses'])) {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "TRUNCATE TABLE usercheck";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Responses cleared successfully."); window.location.href = "home.php";</script>';
    } else {
        echo "Error clearing responses: " . $conn->error;
    }

    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1350px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 6px;
            /* Reduced padding */
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .dropdown {
            position: absolute;
            display: inline-block;
            margin-left: -28px;
            margin-top: -20px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .clear-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .clear-button:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">OTAS</a>
            <a class="navbar-brand" href="home.php">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <nav class="navbar">
                        <ul class="nav-list">
                            <li class="dropdown">
                                <a href="#" class="nav-link dropdown-toggle" href="#"
                                    id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">COMPLAINT</a>
                                <div class="dropdown-content">
                                    <a href="portal_complaint.php">USER</a>
                                    <a href="corecomp.php">CORE</a>
                                    <a href="eleccomp.php">ELECTIVE</a>
                                    <a href="labcomp.php">LABORATORY</a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </ul>
                <div class="navbar-text">
                    <a href="logout.php">Log Off</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>USER COMPLAINT</h1>
        <table>
            <thead>
                <tr>
                    <th>USN</th>
                    <th>Corrected USN</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Semester</th>
                    <th>Section</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM usercheck";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["usn"] . "</td>";
                        echo "<td>" . $row["corrected_usn"] . "</td>";
                        echo "<td>" . $row["fname"] . "</td>";
                        echo "<td>" . $row["lname"] . "</td>";
                        echo "<td>" . $row["semester"] . "</td>";
                        echo "<td>" . $row["section"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <button type="submit" name="clear_responses" class="clear-button">Clear Responses</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-L/cbQaRzwZ9GLgH+3bVgpSO+RhHGQpbllM4p3lDxK5i0TV5PQnW5TO8wP53YZZdh"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-QFYWzvBwlZFlzQBY9Ol7+q65DBJ19GfppLYpruTrJ8N4q6S9cYQmMVG0wJa6h8Au"
        crossorigin="anonymous"></script>
</body>

</html>
