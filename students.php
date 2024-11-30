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
    if (isset($_POST['submit-course'])) {

        if (empty($_POST['course'])){
            echo "An course number is required <br/>";
        } else {
            // Write Query for all students
            $sql = '
                SELECT 
                    classroom, meeting_days, start_time, end_time, seats 
                FROM 
                    sections WHERE course_id = ?
            ';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $_POST['course']); // Assuming 'id' is a string; use 'i' for integers.
            $stmt->execute();
            $result = $stmt->get_result();

            // Fetch data
            $students = [];
            if ($result->num_rows > 0) {
                $total = 0;
                while ($row = $result->fetch_assoc()) {
                    $total += 1;
                    $student[] = $row;
                }
                echo "Total: " . "<b>" . $total . "</b> " . "results found" . "<br>";
            } else {
                echo "No results found.";
            } // End of fetching data

            // Free result from memory
            $stmt->free_result();
            $stmt->close();

            print_r($student);

        } // End of validation
        
    }

    // Check if submit btn is pressed for enrollment records
    if (isset($_POST['submit-cwid'])) {

        if (empty($_POST['cwid'])){
            echo "An CWID is required <br/>";
        } else {
            // Write Query for the students enrollment record
            $sql = '
                SELECT 
                    C.title, 
                    ER.grade
                FROM 
                    enrollment_records AS ER
                JOIN 
                    sections AS S ON ER.section_id = S.section_id
                JOIN 
                    courses AS C ON S.course_id = C.course_id
                WHERE 
                    ER.CWID = ?
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
        } // End of Validation

    }

?>

<!DOCTYPE html>
<html lang="en">
    <?php include ('templates/header.php');?>

    <section class="container grey-text">
        <h4>For Students</h4>
        <hr>
        <h6 class="center">Search Course Catalog</h6>
        <form action="students.php" class="white" method="POST">
            <label>Course Number</label>
            <input type="text" name="course">
            <div class="center">
                <input 
                    type="submit" name="submit-course" 
                    value="submit"
                    class="btn z-depth-0"    
                >
            </div>
        </form>
        <h6 class="center">Search Enrollment Records</h6>
        <form action="students.php" class="white" method="POST">
            <label>CWID</label>
            <input type="text" name="cwid">
            <div class="center">
                <input 
                    type="submit" name="submit-cwid" 
                    value="submit"
                    class="btn z-depth-0"    
                >
            </div>
        </form>
    </section>

    <?php include ('templates/footer.php');?>
</html>