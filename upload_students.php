<?php
session_start();
if(isset($_SESSION['username'])){
}
else {
        echo '<script>alert("Please login to continue.");</script>';
        header("Location:login.html");
}

if(isset($_POST["submit"])) {
    
    if($_FILES["excel_file"]["error"] == 0) {
        
        $file_tmp = $_FILES["excel_file"]["tmp_name"];
        
        
        require 'PHPExcel-1.8/Classes/PHPExcel.php';
        
        $excel = PHPExcel_IOFactory::load($file_tmp);
        
        
        $sheet = $excel->getActiveSheet();
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "otas";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
       
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        
        $skipFirstRow = true;
        
        
        $columnMapping = array(
            'USN' => 'USN',
            'First Name' => 'First_Name',
            'Last Name' => 'Last_Name',
            'Phone Number' => 'Phone_Number',
            'Sem' => 'Sem',
            'Email' => 'Email',
            'Dept Id' => 'Dept_Id',
            'Batch' => 'Batch',
            'Section' => 'Section'
        );
        
        
        foreach ($sheet->getRowIterator() as $row) {
            
           
            if ($skipFirstRow) {
                $skipFirstRow = false;
                continue;
            }
            
            
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); 
            
            
            $data = array();
            $isEmptyRow = true; 
            
            
            foreach ($cellIterator as $cell) {
                
                $cellValue = $cell->getValue();
                
                if (!empty($cellValue)) {
                    $isEmptyRow = false; 
                }
                

$columnLetter = $cell->getColumn();


$columnIndex = PHPExcel_Cell::columnIndexFromString($columnLetter) - 1;


$columnHeading = $sheet->getCellByColumnAndRow($columnIndex, 1)->getValue();


                if (isset($columnMapping[$columnHeading])) {
                    
                    $dbColumnName = $columnMapping[$columnHeading];
                    
                    if ($dbColumnName === 'Sem' || $dbColumnName === 'Batch') {
                        $data[$dbColumnName] = (int)$cellValue;
                    } else {
                       
                        $data[$dbColumnName] = $cellValue;
                    }
                }
            }
            
            
            if ($isEmptyRow) {
                continue; 
            }
            
            $sql = "INSERT INTO student (USN, First_Name, Last_Name, Phone_Number, Sem, Email, Dept_Id, Batch, Section) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            $stmt->bind_param("ssssissis",$data['USN'] , $data['First_Name'], $data['Last_Name'], $data['Phone_Number'], $data['Sem'], $data['Email'], $data['Dept_Id'], $data['Batch'], $data['Section']);
            
            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
        
        
        $conn->close();
        echo '<script>alert("Student Details stored in the database successfully."); window.location.href = "home.php";</script>';

    } else {
        echo "Error uploading file.";
    }
}
?>