<?php
session_start();
if(isset($_SESSION['username'])){
}

else {
        echo '
<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "otas";


                $conn = new mysqli($servername, $username, $password, $dbname);


                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Report</title>
    <style>
        
        @page {
            size: A4;
            margin: 0;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
        }
        .header img {
            height: 200px; 
        }
        .header h1 {
    font-family: 'Times New Roman', Times, serif;
    margin: 0;
    padding-bottom: 10px; 
    width: 100%;
    text-align: center;
    box-sizing: border-box;
}

.header h3 {
    font-family: 'Times New Roman', Times, serif;
    margin: 0;
    padding-top: 10px; 
    width: 82%;
    text-align: center;
    box-sizing: border-box;
}
        h2{
            text-align:center;}
        body {
            margin: 20mm;
        }
        .container {
            width: 100%;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .count_class {
            width: 48%;
            border-collapse: collapse;
        }
        .count_class, .count_class th, .count_class td {
            border: 2px solid black;
            padding: 5px;
            text-align: left;
        }
        .overa_class {
            width: 48%;
            border-collapse: collapse;
        }
        .overa_class, .overa_class th, .overa_class td {
            border: 2px solid black;
            padding: 5px;
            text-align: left;
        }
        .bar-chart-container {
            width: 57%;
            margin: 0px auto;
            margin-bottom:200px;
        }
        .fit{
            display:flex;
            justify-content: space-between;
        }
        #barChart{
            height:100%;
        }
    </style>
</head>
<body>
<div class="header">
    <img src="https://collegesdirectory.in/World/MasterAdmin/College-Master/College_Logo/Logo-165557347.jpg"
         alt="RNS Institute of Technology Logo">
    <div style="display: flex; flex-direction: column; align-items: center;">
        <h1>RNS INSTITUTE OF TECHNOLOGY</h1>
        <h3 style="margin-top: 10px;">Affiliated to VTU, Recognized by GOK, Approved by AICTE. Located in New Delhi, NAAC 'A+ Grade' Accredited. Also, NBA Accredited (UGCSE, ECE, ISE, EIE and EEE). Situated in Channasandra, Dr. Vishnuvardhan Road, Bengaluru - 560 098. Contact: (080)28611880,28611881. Visit us at www.rnsit.ac.in</h3>
    </div>
</div>

<div class="container">
    
    <table class="table">
        <tbody>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otas";
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$subCode = $_GET['subCode'];
$sem = $_GET['sem'];
$section = $_GET['section'];


$sql = "SELECT d.DepName, t.Sem, t.Section, c.Teacher_FName, c.Teacher_LName, t.SubCode, j.SubName
        FROM department AS d
        JOIN teacher_subcombo AS t ON d.DeptId = t.DeptId
        JOIN teacher AS c ON t.Tid = c.Tid
        JOIN subjects AS j ON t.SubCode = j.SubCode
        WHERE t.SubCode = '$subCode' AND t.Sem='$sem' and t.Section = '$section'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        $currentYear = date("Y");
        
        $nextYear = date("Y", strtotime('+1 year'));
        
        $academicYear = $currentYear . "-" . $nextYear;

        echo "<tr>";
        echo "<td style='font-weight: bold;'>Academic Year:</td>";
        echo "<td colspan='3'>" . $academicYear . "</td>";
        echo "<td style='font-weight: bold;'>Department:</td>";
        echo "<td colspan='2'>" . $_SESSION['username'] . "</td>";
        echo "<td style='font-weight: bold;'>Sem:</td>";
        echo "<td>" . $row['Sem'] . "</td>";
        echo "<td style='font-weight: bold;'>Section:</td>";
        echo "<td>" . $row['Section'] . "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style='font-weight: bold;'>Staff Name:</td>";
        echo "<td colspan='3'>" . $row['Teacher_FName'] . " " . $row['Teacher_LName'] . "</td>";
        echo "<td style='font-weight: bold;'>Staff Dept:</td>";
        echo "<td colspan='3'>" . $row['DepName'] . "</td>";
        echo "<td style='font-weight: bold;'>Subcode:</td>";
        echo "<td colspan='2'>" . $row['SubCode'] . "</td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td style='font-weight: bold;'>Subject:</td>";
        echo "<td colspan='10'>" . $row['SubName'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='12'>No teacher details found</td></tr>";
}
$conn->close();
?>
        </tbody>
    </table>
</div>


<div class="container">
    
    <table class="table">
        <thead>
            <tr>
                <th>Questions</th>
                <th>1 Star</th>
                <th>2 Star</th>
                <th>3 Star</th>
                <th>4 Star</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
        <?php
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "otas";
        $conn = new mysqli($servername, $username, $password, $dbname);

        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        
        $subCode = $_GET['subCode'];
        $sem = $_GET['sem'];
        $section = $_GET['section'];

        
        $sql = "SELECT 
        q_text,
        SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) AS '1 Star',
        SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) AS '2 Star',
        SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) AS '3 Star',
        SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) AS '4 Star'
    FROM 
        (SELECT 
            CASE
                WHEN t.core = 1 THEN 'Core'
                WHEN t.elective = 1 THEN 'Elective'
                WHEN t.lab = 1 THEN 'Lab'
            END AS subject_type,
            CASE
                WHEN t.core = 1 THEN c.rating
                WHEN t.elective = 1 THEN e.rating
                WHEN t.lab = 1 THEN l.rating
            END AS rating,
            CASE
                WHEN t.core = 1 THEN r.q_text
                WHEN t.elective = 1 THEN eq.q_text
                WHEN t.lab = 1 THEN lq.q_text
            END AS q_text
        FROM 
            teacher_subcombo t
        LEFT JOIN core_subject_response c ON t.SubCode = c.SubCode AND t.Sem = c.Sem AND t.Section = c.Section AND t.core = 1
        LEFT JOIN core_subject_question r ON c.q_Id = r.q_Id
        LEFT JOIN elective_response e ON t.SubCode = e.SubCode AND t.Sem = e.Sem AND t.Section = e.Section AND t.elective = 1
        LEFT JOIN elective_question eq ON e.q_Id = eq.q_Id
        LEFT JOIN lab_response l ON t.SubCode = l.SubCode AND t.Sem = l.Sem AND t.Section = l.Section AND t.lab = 1
        LEFT JOIN lab_question lq ON l.q_Id = lq.q_Id
        WHERE 
            t.SubCode = '$subCode' AND
            t.Sem = '$sem' AND
            t.Section = '$section'
        ) AS sub
    GROUP BY 
        q_text;
    
    ";

        $result = $conn->query($sql);

        
        $remarks = array();

        
        $total_1_star_all = 0;
        $total_2_star_all = 0;
        $total_3_star_all = 0;
        $total_4_star_all = 0;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                
                $total_1_star_all += $row['1 Star'];
                $total_2_star_all += $row['2 Star'];
                $total_3_star_all += $row['3 Star'];
                $total_4_star_all += $row['4 Star'];

                
                $total_1_star = $row['1 Star'];
                $total_2_star = $row['2 Star'];
                $total_3_star = $row['3 Star'];
                $total_4_star = $row['4 Star'];

                
                $highest_count = max($total_1_star, $total_2_star, $total_3_star, $total_4_star);

                
                $remark = '';
                if ($highest_count == $total_4_star) {
                    $remark = 'Excellent';
                } elseif ($highest_count == $total_3_star) {
                    $remark = 'Good';
                } elseif ($highest_count == $total_2_star) {
                    $remark = 'Average';
                } elseif ($highest_count == $total_1_star) {
                    $remark = 'Poor';
                }

                
                $remarks[] = $remark;

                
                echo "<tr>";
                echo "<td>" . $row['q_text'] . "</td>";
                echo "<td>" . $total_1_star . "</td>";
                echo "<td>" . $total_2_star . "</td>";
                echo "<td>" . $total_3_star . "</td>";
                echo "<td>" . $total_4_star . "</td>";
                echo "<td>" . $remark . "</td>";
                echo "</tr>";
            }

            
            echo "<tr>";
            echo "<td>Total</td>";
            echo "<td>" . $total_1_star_all . "</td>";
            echo "<td>" . $total_2_star_all . "</td>";
            echo "<td>" . $total_3_star_all . "</td>";
            echo "<td>" . $total_4_star_all . "</td>";
            echo "<td></td>"; 
            echo "</tr>";
        } else {
            echo "<tr><td colspan='7'>No feedback questions found</td></tr>";
        }

        $conn->close();
        ?>
        </tbody>
    </table>
</div>

<div class="fit">
    <table class="count_class">
        <tr>
            <td style="text-align:center; font-weight: bold;">No. of Students</td>
            <td style="text-align:center;"></td>
        </tr>
        <tr>
            <td style="text-align:center; font-weight: bold;">Percentage</td>
            <td style="text-align:center;">80.5%</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center; font-weight: bold;">Comments</td>
        </tr>
        <tr>
            <td style="text-align:center; font-weight: bold; ">PRINCIPAL:</td>
            <td style="border-bottom: 2px solid white;"></td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: 2px solid white; border-right: 3px solid black;  border-left: 3px solid black;"></td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: 2px solid white; border-right: 3px solid black; border-left: 3px solid black;"></td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: 2px solid white; border-right: 3px solid black; border-left: 3px solid black;"></td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: 2px solid white; border-right: 3px solid black; border-left: 3px solid black;"></td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: 2px solid white; border-right: 3px solid black; border-left: 3px solid black;"></td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: 2px solid white; border-right: 3px solid black; border-left: 3px solid black;"></td>
        </tr>
        <tr>
            <tr>
                <td style="border-top: 2px solid white;"></td>
                <td style="text-align:center; border-left: 3px solid white; border-top: 2px solid white;">SIGNATURE</td>
            </tr>
        </tr>
        <tr>
            <td style="text-align:center; font-weight: bold; ">PRINCIPAL:</td>
            <td style="border-bottom: 2px solid white;"></td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: 2px solid white; border-right: 3px solid black;  border-left: 3px solid black;"></td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: 2px solid white; border-right: 3px solid black; border-left: 3px solid black;"></td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: 2px solid white; border-right: 3px solid black; border-left: 3px solid black;"></td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: 2px solid white; border-right: 3px solid black; border-left: 3px solid black;"></td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: 2px solid white; border-right: 3px solid black; border-left: 3px solid black;"></td>
        </tr>
        <tr>
            <td colspan="2" style="border-bottom: 2px solid white; border-right: 3px solid black; border-left: 3px solid black;"></td>
        </tr>
        <tr>
            <tr>
                <td style="border-top: 2px solid white;"></td>
                <td style="text-align:center; border-left: 3px solid white; border-top: 2px solid white;">SIGNATURE</td>
            </tr>
        </tr>
    </table>
    <table class="overa_class">
        <tr>
            <td style="font-weight: bold; ">Overall Performance</td>
            <td style="text-align:center;"><?php echo $remark; ?></td>
            <td style="text-align:center;">
        <?php
        
        function generateStars($remark) {
            switch ($remark) {
                case 'Excellent':
                    return '⭐⭐⭐⭐'; 
                    break;
                case 'Good':
                    return '⭐⭐⭐'; 
                    break;
                case 'Average':
                    return '⭐⭐'; 
                    break;
                case 'Poor':
                    return '⭐'; 
                    break;
                default:
                    return ''; 
                    break;
            }
        }

         
        echo generateStars($remark);
        ?>
    </td>
        </tr>
        <tr>
            <td style="font-weight: bold; border-right: 2px solid black;">Analysis:</td>
        </tr>
        <tr>
            <td style="border-right: 2px solid white; padding: 20px;"> 
                <div class="bar-chart-container" style="height: 100px;"> 
                <canvas id="barChart" width="750" height="1000"></canvas>
                </div>
            </td>
        </tr>
    </table>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
    
    const data = {
        labels: ['1 Star', '2 Stars', '3 Stars', '4 Stars'],
        datasets: [{
            label: 'Number of Reviews',
            data: [
                <?php echo $total_1_star_all; ?>, 
                <?php echo $total_2_star_all; ?>, 
                <?php echo $total_3_star_all; ?>, 
                <?php echo $total_4_star_all; ?>  
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    };

    
    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    
    var myChart = new Chart(
        document.getElementById('barChart'),
        config
    );
</script>

</body>
</html>
