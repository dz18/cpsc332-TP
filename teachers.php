<?php

    // Database Parameters
    $host = "localhost";
    $name = "root";
    $password = "";
    $db = "cs332g26";

    // Connect to the database
    $conn = mysqli_connect($host, $name, $password, $db);

    // Check Connection
    if (!$conn){
        echo "Connection error: " . mysqli_connect_error();
    }

    $data = [];
    $total = 0;
    $query = '';

    // Check if submit btn is pressed for course catalog
    if (isset($_POST['submit-ssn'])) {

        if (empty($_POST['ssn'])){
            $query = "no-results";
        } else {
            // Write Query for the Professors Courses
            $sql = '
                SELECT
                    C.title,
                    S.classroom,
                    S.meeting_days,
                    S.start_time,
                    S.end_time
                FROM 
                    sections AS S
                JOIN
                    courses AS C ON C.course_id = S.course_id
                WHERE 
                    S.teacher = ?
            ';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $_POST['ssn']); 
            $stmt->execute();
            $result = $stmt->get_result();

            // Fetch data
            if ($result->num_rows > 0) {
                $query = "professor-courses";
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

        }  // End of validation

    } 

    // Check if submit btn is pressed for enrollment records
    if (isset($_POST['submit-course'])) {
        if (empty($_POST['course']) || empty($_POST['section'])){
            $query = "no-results";
        } else {
            $sql = '
                SELECT 
                    ER.grade, 
                    COUNT(*) AS Count
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
            $stmt->bind_param('ss', $_POST['section'], $_POST['course']); // Assuming 'id' is a string; use 'i' for integers.
            $stmt->execute();
            $result = $stmt->get_result();

            // Fetch data
            if ($result->num_rows > 0) {
                $query = "grades";
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

?>

<!DOCTYPE html>
<html lang="en">
    <?php include ('templates/header.php');?>

    <section class="container">
        <h4 class="grey-text">For Teachers</h4>
        <hr>

        <!-- Forms -->
        <div class="row grey-text">
            <div class="flex-container">
                <div class="card z-depth-0 flex-item">
                    <div class="card-content">
                        <h6 class="center">Search a Professor's Courses</h6>
                        <form action="" class="white myForm" method="POST">
                            <label>SSN</label>
                            <input type="text" name="ssn">
                            <div class="center">
                                <input 
                                    type="submit" name="submit-ssn" 
                                    value="Submit"
                                    class="btn z-depth-0"    
                                >
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card z-depth-0 flex-item">
                    <div class="card-content">
                        <h6 class="center">Search for All Grades in a Section</h6>
                        <form action="" class="white myForm" method="POST">
                            <label class="center">Course ID</label>
                            <input type="text" name="course">
                            <label class="center">Section ID</label>
                            <input type="text" name="section">
                            <div class="center">
                                <input 
                                    type="submit" name="submit-course" 
                                    value="Submit"
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
                <?php if ($query == "professor-courses") { ?>
                    
                    <h4>Results for: <b>Professors Courses</b></h4>
                    <h6>Total Results Found: <b><?php echo $total;?></b></h6>
                <?php } else if ($query == "grades") { ?>
                    
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
        
    </div>

        
        


    </section>

    <?php include ('templates/footer.php');?>
</html>