<?php
session_start(); 

if (isset($_SESSION['username'])) {
    $usn = $_SESSION['username'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "otas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $sem = $_GET['sem'];
    $section = $_GET['section'];

    
    $sql_subjects = "SELECT subjects.SubCode, subjects.SubName, teacher_subcombo.Lab, teacher_subcombo.Elective, teacher.Teacher_FName, teacher.Teacher_LName, teacher.Tid
    FROM subjects 
    INNER JOIN teacher_subcombo ON subjects.SubCode = teacher_subcombo.SubCode 
    INNER JOIN teacher ON teacher_subcombo.Tid = teacher.Tid 
    WHERE  teacher_subcombo.Sem = '$sem' 
    AND teacher_subcombo.Section = '$section'
    ORDER BY teacher_subcombo.SubCode";

    $result_subjects = $conn->query($sql_subjects);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Questions</title>
    <style>
        
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .question-box {
            margin-bottom: 20px;
        }

        .question {
            font-weight: bold;
        }

        .options {
            display: grid;
            grid-template-columns: auto auto;
            grid-gap: 10px;
        }
        .info-box {
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        $subject_index = 0; 
        ?>
        <?php while ($row_subject = $result_subjects->fetch_assoc()): ?>
            <?php
            $subject = $row_subject['SubName'];
            $subcode = $row_subject['SubCode'];
            $teacher_name = $row_subject['Teacher_FName'] . ' ' . $row_subject['Teacher_LName'];
            $teacher_id = $row_subject['Tid'];
            $type = $row_subject['Lab'] == 1 ? "lab" : ($row_subject['Elective'] == 1 ? "elective" : "core");

            
            if ($type == "lab") {
                $question_table = "lab_question";
            } elseif ($type == "elective") {
                $question_table = "elective_question";
            } else {
                $question_table = "core_subject_question";
            }

            $sql_questions = "SELECT * FROM $question_table";
            $result_questions = $conn->query($sql_questions);
            ?>

            <div class="subject-section" id="subject_<?php echo $subject_index; ?>" <?php if ($subject_index != 0) echo "style='display: none;'"; ?>>
                <div class="info-box">
                    <p><strong>Teacher:</strong> <?php echo $teacher_name; ?></p>
                    <p><strong>Subject:</strong> <?php echo $subject; ?></p>
                    <p><strong>Subject Code:</strong> <?php echo $subcode; ?></p>
                    <p><strong>Semester:</strong> <?php echo $sem; ?></p>
                </div>

                <form action="process_answers.php" method="post">
                    <input type="hidden" name="usn" value="<?php echo $usn; ?>">
                    <input type="hidden" name="section" value="<?php echo $section; ?>">
                    <input type="hidden" name="sem" value="<?php echo $sem; ?>">
                    <input type="hidden" name="subcode" value="<?php echo $subcode; ?>">
                    <input type="hidden" name="subject" value="<?php echo $subject; ?>">
                    <input type="hidden" name="type" value="<?php echo $type; ?>">
                    <input type="hidden" name="teacher" value="<?php echo $teacher_name; ?>">
                    <input type="hidden" name="teacher_id" value="<?php echo $teacher_id; ?>">

                    <?php if ($result_questions->num_rows > 0): ?>
                        <?php while ($row_question = $result_questions->fetch_assoc()): ?>
                            <div class='question-box'>
                                <p class='question'><?php echo $row_question['q_text']; ?></p>
                                <div class='options'>
                                    <label><input type='radio' name='answer[<?php echo $row_question['q_Id']; ?>]' value='4'><?php echo $row_question['option_1']; ?></label>
                                    <label><input type='radio' name='answer[<?php echo $row_question['q_Id']; ?>]' value='3'><?php echo $row_question['option_2']; ?></label>
                                    <label><input type='radio' name='answer[<?php echo $row_question['q_Id']; ?>]' value='2'><?php echo $row_question['option_3']; ?></label>
                                    <label><input type='radio' name='answer[<?php echo $row_question['q_Id']; ?>]' value='1'><?php echo $row_question['option_4']; ?></label>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No questions found.</p>
                    <?php endif; ?>

                    <button type="submit">Submit Answers</button>
                </form>
            </div>

            <?php
            $subject_index++;
            ?>
        <?php endwhile; ?>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
    const subjectSections = document.querySelectorAll(".subject-section");
    let currentSubjectIndex = 0;

    function showNextSubject() {
        subjectSections[currentSubjectIndex].style.display = "none";
        currentSubjectIndex++;
        if (currentSubjectIndex < subjectSections.length) {
            
            setTimeout(() => {
                subjectSections[currentSubjectIndex].style.display = "block";
                
                window.scrollTo(0, 0);
            }, 100); 
        } else {
            window.location.href = 'feedback.php';
        }
    }
    const submitButtons = document.querySelectorAll("form button[type='submit']");
    submitButtons.forEach(button => {
        button.addEventListener("click", function(event) {
            event.preventDefault(); 

            
            const form = button.closest('form');
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        
                        showNextSubject();
                    } else {
                        throw new Error('Form submission failed.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error occurred. Please try again.');
                });
        });
    });
    
});

</script>

</body>
</html>

<?php
$conn->close();
?>
