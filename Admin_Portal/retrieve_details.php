<?php
session_start();
if(isset($_SESSION['username'])){
    $mysqli = new mysqli("localhost", "root", "", "otas");

        if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
       
        }
}
else {
        echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}
?>

<table>
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th>Subject Code</th>
                        <th>Teacher Name</th>
                        <th colspan="2">Actions</th>
                    </tr>
                </thead>
<tbody>
<?php
$branch = $_POST['branch'];
$sem = $_POST['sem'];
$sec = $_POST['sec'];

$query = "SELECT c.comboid, s.SubName, c.SubCode, CONCAT_WS(' ', t.Teacher_FName, t.Teacher_LName) AS teacher_name
          FROM teacher_subcombo c
          INNER JOIN teacher t ON t.tid = c.tid
          INNER JOIN subjects s ON s.subcode = c.subcode
          WHERE c.deptid = ? AND c.sem = ? AND c.section = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("sss", $branch, $sem, $sec);
$stmt->execute();
$result = $stmt->get_result();


while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<input type='hidden' class='comboid' value='" . $row['comboid'] . "'>";
    echo "<td>" . $row['SubName'] . "</td>";
    echo "<td>" . $row['SubCode'] . "</td>";
    echo "<td>" . $row['teacher_name'] . "</td>";
    
    echo "<td><button class='editBtn'>Edit</button></td>";
    echo "<td><button class='deleteBtn' data-subcode='" . $row['comboid'] . "'>Delete</button></td>";
    echo "</tr>";
}

// Close the prepared statement
$stmt->close();
$mysqli->close();
?>
</tbody>
</table>


<script>
    
    $(document).ready(function() {
    var editingRow = null; 

    $(document).on("click", ".editBtn", function(event) {
        event.preventDefault(); 
        
        
        editingRow = $(this).closest("tr");

        var subjectName = editingRow.find("td:eq(0)").text();
        var subjectCode = editingRow.find("td:eq(1)").text();
        var teacherName = editingRow.find("td:eq(2)").text();
        var comboid = editingRow.find(".comboid").val();

        $.ajax({
            url: 'other_details.php',
            type: 'POST',
            data: { subjectName: subjectName, subjectCode: subjectCode },
            success: function(response) {
                var data = JSON.parse(response);
                $("#editForm #comboid").val(comboid);
                $("#editForm select[name='subjectName']").val(subjectName);
                $("#editForm select[name='subjectCode']").val(subjectCode);
                $("#editForm select[name='teacherName']").val(teacherName);
                $("#editForm select[name='teacherDepartment']").val(data.teacherDepartment);
                $("#editForm select[name='subjectDepartment']").val(data.subjectDepartment);
                $("#editForm").show();
            }
        });
    });

    $('#saveChangesBtn').click(function(event) {
        event.preventDefault(); 

        
        var comboid = $("#editForm input[name='comboid']").val();
        var teacherName = $("#editForm select[name='teacherName']").val();
        var subjectCode = $("#editForm select[name='subjectCode']").val();

        $.ajax({
            url: 'save_changes.php',
            type: 'POST',
            data:  { comboid: comboid, teacherName: teacherName, subjectCode: subjectCode },
            dataType: 'json', 
            success: function(response) {
                
                if (typeof response === 'object' && response !== null) {
                    
                    comboid = response.comboid;
                    teacherName = response.teacherName;
                    subjectCode = response.subjectCode;
                    var subjectName = response.subjectName;

                    
                    editingRow.find("td:eq(0)").text(subjectName);
                    editingRow.find("td:eq(2)").text(teacherName); 
                    editingRow.find("td:eq(1)").text(subjectCode); 

                    
                    $('#editForm').hide();
                } else {
                    console.error("Invalid response format:", response);
                    alert("An error occurred while saving changes.");
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred while saving changes.");
            }
        });
    });
});

$(document).on("click", ".deleteBtn", function() {
    var comboid = $(this).closest("tr").find(".comboid").val();

    $.ajax({
        url: 'delete_row.php',
        type: 'POST',
        data: { comboid: comboid }, 
        success: function(response) {
            
            alert(response);
            
            location.reload();
        },
        error: function(xhr, status, error) {
            
            console.error(xhr.responseText);
        }
    });
});


</script>
