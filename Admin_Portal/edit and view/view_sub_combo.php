<?php
// Include your database connection here
$host = 'localhost';
$dbname = 'otas';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Adjust the SQL query to join necessary tables and filter by section, semester, and department
$section = $_GET['section']; // Assuming you get section from GET parameters
$semester = $_GET['semester']; // Assuming you get semester from GET parameters
$department = $_GET['department']; // Assuming you get department from GET parameters

// SQL query to retrieve data based on section, semester, and department
$query = "SELECT ts.ComboId, ts.Tid, ts.SubCode, ts.Sem, ts.DeptId, ts.Section
          FROM teacher_subcombo ts
          INNER JOIN teacher t ON ts.Tid = t.Tid
          INNER JOIN subjects s ON ts.SubCode = s.SubCode
          WHERE ts.Section = :section AND ts.Sem = :semester AND ts.DeptId = :department";

// Prepare and execute the query
$stmt = $pdo->prepare($query);
$stmt->execute(array(':section' => $section, ':semester' => $semester, ':department' => $department));

// Fetch data
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Pagination
$limit = 10; // Number of rows per page
$total_rows = count($data);
$total_pages = ceil($total_rows / $limit);

if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

$start = ($page - 1) * $limit;
$end = $start + $limit;
if ($end > $total_rows) {
    $end = $total_rows;
}

// Display data
foreach (array_slice($data, $start, $limit) as $row) {
    echo "<tr>";
    foreach ($row as $value) {
        echo "<td>$value</td>";
    }
    echo "<td class='actions'>
            <a href='edit_sub_combo.html?ComboId={$row['ComboId']}'>Edit</a>
            <a href='delete_sub_combo.php?ComboId={$row['ComboId']}'>Delete</a>
          </td>";
    echo "</tr>";
}

// Pagination links
echo "<tr><td colspan='7'>";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='view_sub_combo.php?page=$i&section=$section&semester=$semester&department=$department'>$i</a> ";
}
echo "</td></tr>";
?>