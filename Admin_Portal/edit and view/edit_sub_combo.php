<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otas";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $comboId = $_POST["comboId"];

    // Construct SQL update query based on submitted fields
    $sql = "UPDATE teacher_subcombo SET ";
    foreach ($_POST as $key => $value) {
        if ($key != "comboId") {
            // Escape user inputs to prevent SQL injection
            $key = mysqli_real_escape_string($conn, $key);
            $value = mysqli_real_escape_string($conn, $value);

            // If the value is empty, retain the previous value
            if ($value === "") {
                $sql .= "$key = $key, "; // Assign the same value back
            } else {
                $sql .= "$key = '$value', "; // Use the provided value
            }
        }
    }
    // Remove the trailing comma and space
    $sql = rtrim($sql, ", ");
    $sql .= " WHERE ComboId = '$comboId'";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Record updated successfully</p>";
    } else {
        echo "<p>Error updating record: " . $conn->error . "</p>";
    }

    $conn->close();
}
?>