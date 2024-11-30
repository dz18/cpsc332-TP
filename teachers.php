<?php

    // Database Parameters
    $host = "localhost";
    $name = "dylan";
    $password = "test123";
    $db = "cpsc332g26";

    // Connect to the database
    $conn = mysqli_connect($host, $name, $password, $db);

    // Check Connection
    if (!$conn){
        echo "Connection error: " . mysqli_connect_error();
    }

    // Check if submit btn is pressed for course catalog
    if (isset($_POST['submit-ssn'])) {

        if (empty($_POST['ssn'])){
            echo "An ssn number is required <br/>";
        } else {
            // Write Query for the students enrollment record
            $sql = '
                SELECT 
                    courses.title, 
                    sections.classroom,
                    sections.meeting_days,
                    sections.start_time,
                    sections.end_time,
                FROM 
                    section as S
                JOIN 
                    courses ON sections.course_id = courses.course_id
                WHERE 
                    section.ssn = ?
            ';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $_POST['cwid']); // Assuming 'id' is a string; use 'i' for integers.
            $stmt->execute();
            $result = $stmt->get_result();

            // Fetch data
            $students = [];
            if ($result->num_rows > 0) {
                $total = 0;
                while ($row = $result->fetch_assoc()) {
                    $total += 1;
                    $records[] = $row;
                }
                echo "Total: " . "<b>" . $total . "</b> " . "results found" . "<br>";
            } else {
                echo "No results found.";
            } // End of fetching data

            // Free result from memory
            $stmt->free_result();
            $stmt->close();

            print_r($records);
        }  // End of validation

    } 

    // Check if submit btn is pressed for enrollment records
    if (isset($_POST['submit-course'])) {

        if (empty($_POST['course']) || empty($_POST['section'])){
            echo "An course ID and section ID is required <br/>";
        } else {
            $sql = '
                SELECT 
                    ER.grade, 
                    COUNT(*) AS StudentCount
                FROM 
                    enrollment_records AS ER
                JOIN 
                    sections AS S ON ER.section_id = S.section_id
                JOIN 
                    courses AS C ON S.course_id = C.course_id
                WHERE 
                    S.section_id = ? AND C.course_id = ?
                GROUP BY 
                    ER.grade
            ';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $_POST['section'], $_POST['course']); // Assuming 'id' is a string; use 'i' for integers.
            $stmt->execute();
            $result = $stmt->get_result();

            // Fetch data
            $students = [];
            if ($result->num_rows > 0) {
                $total = 0;
                while ($row = $result->fetch_assoc()) {
                    $total += 1;
                    $records[] = $row;
                }
                echo "Total: " . "<b>" . $total . "</b> " . "results found" . "<br>";
            } else {
                echo "No results found.";
            } // End of fetching data

            // Free result from memory
            $stmt->free_result();
            $stmt->close();

            print_r($records);
        } // End of validation

    }

?>

<!DOCTYPE html>
<html lang="en">
    <?php include ('templates/header.php');?>

    <section class="container grey-text">
        <h4>For Teachers</h4>
        <hr>
        <h6 class="center">Search Professor</h6>
        <form action="" class="white" method="POST">
            <label>SSN</label>
            <input type="text" name="ssn">
            <div class="center">
                <input 
                    type="submit" name="submit-ssn" 
                    value="submit"
                    class="btn z-depth-0"    
                >
            </div>
        </form>
        <h6 class="center">Search Grade Results</h6>
        <form action="" class="white" method="POST">
            <label class="center">Course ID</label>
            <input type="text" name="course">
            <label class="center">Section ID</label>
            <input type="text" name="section">
            <div class="center">
                <input 
                    type="submit" name="submit-course" 
                    value="submit"
                    class="btn z-depth-0"    
                >
            </div>
        </form>
    </section>

    <?php include ('templates/footer.php');?>
</html>