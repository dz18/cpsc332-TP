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

    // Initialize result variables
    $data = [];
    $total = 0;
    $query = '';

    // Check if submit btn is pressed for course catalog
    if (isset($_POST['submit-course'])) {

        if (empty($_POST['course'])){
            $query = "no-results";
        } else {
            // Write Query for all students
            $sql = '
                SELECT 
                    C.title AS course_title,
                    S.section_id,
                    S.classroom,
                    S.meeting_days,
                    S.start_time,
                    S.end_time,
                    COUNT(ER.CWID) AS num_students
                FROM 
                    sections AS S
                JOIN 
                    courses AS C ON S.course_id = C.course_id
                LEFT JOIN 
                    enrollment_records AS ER ON S.section_id = ER.section_id
                WHERE 
                    C.course_id = ? 
                GROUP BY 
                    S.section_id, S.classroom, S.meeting_days, S.start_time, S.end_time
                ORDER BY 
                    S.section_id;
            ';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $_POST['course']); // Assuming 'id' is a string; use 'i' for integers.
            $stmt->execute();
            $result = $stmt->get_result();

            // Fetch data
            if ($result->num_rows > 0) {
                $query = "course-catalog";
                $total = $result->num_rows;
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            } else {
                $query = "no-results";
            } // End of fetching data

            // Free result from memory
            $stmt->free_result();
            $stmt->close();

        } // End of validation
        
    }

    // Check if submit btn is pressed for enrollment records
    if (isset($_POST['submit-cwid'])) {

        if (empty($_POST['cwid'])){
            $query = "no-results";
        } else {
            // Write Query for the students enrollment record
            $sql = '
                SELECT 
                    C.title AS course_title,
                    ER.grade
                FROM 
                    enrollment_records AS ER
                JOIN 
                    sections AS S ON ER.section_id = S.section_id
                JOIN 
                    courses AS C ON S.course_id = C.course_id
                WHERE 
                    ER.CWID = ?
                ORDER BY 
                    C.title;
            ';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $_POST['cwid']); // Assuming 'id' is a string; use 'i' for integers.
            $stmt->execute();
            $result = $stmt->get_result();

            // Fetch data
            if ($result->num_rows > 0) {
                $query = "ER";
                $total = $result->num_rows;
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            } else {
                $query = "no-results";
            } // End of fetching data

            // Free result from memory
            $stmt->free_result();
            $stmt->close();

        } // End of Validation

    }

?>

<!DOCTYPE html>
<html lang="en">
    <?php include ('templates/header.php');?>

    <section class="container">
        <h4 class="grey-text">For Students</h4>
        <hr>

        <!-- Forms -->
        <div class="row grey-text">
            <div class="flex-container">
                <div class="card z-depth-0 flex-item">
                    <div class="card-content">
                        <h6 class="center">Search Course Catalog</h6>
                        <form action="students.php" class="white myForm" method="POST">
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
                    </div>
                        
                </div>
                <div class="card z-depth-0 flex-item">
                    <div class="card-content">                    
                        <h6 class="center">Search Enrollment Records</h6>
                        <form action="students.php" class="white myForm" method="POST">
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
                    </div>
                </div>
            </div>
        </div>

        <!-- Results -->
        <div>
            <div class="grey-text">
                <?php if ($query == "course-catalog") { ?>
                    <h4>Results for: <b>Course Catalog</b></h4>
                    <h6>Total Results Found: <b><?php echo $total;?></b></h6>
                <?php } else if ($query == "ER") { ?>
                    <h4>Results for: <b>Total Class Grades</b></h4>
                    <h6>Total Results Found: <b><?php echo $total;?></b></h6>
                <?php } else if ($query == "no-results") { ?>
                    <h4>No Results Found. <b>Try Again</b></h4>
                <?php } ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <?php if (!empty($data)) {
                            foreach (array_keys($data[0]) as $header) {
                                echo "<th>" . htmlspecialchars($header) . "</th>";
                            }
                        } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row) { ?>
                        <tr>
                            <?php foreach ($row as $value) { ?>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>


    </section>

    <?php include ('templates/footer.php');?>
</html>