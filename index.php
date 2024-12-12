
<?php
    // Database Parameters
    $host = "localhost";
    $name = "dylan";
    $password = "test123";
    $db = "cs332g26";

    // Connect to the database
    $conn = mysqli_connect($host, $name, $password, $db);

    // Check Connection
    if (!$conn){
        echo "Connection error: " . mysqli_connect_error();
    }

    $type = $_POST['type'] ?? 'professors';
    $sql = '';

    switch ($type) {
        case 'professors':
            $sql = 'SELECT * FROM  professors';
            break;
        case 'departments':
            $sql = 'SELECT * FROM  departments';
            break;
        case 'enrollment_records':
            $sql = 'SELECT * FROM  enrollment_records';
            break;
        case 'courses':
            $sql = 'SELECT * FROM  courses';
            break;
        case 'sections':
            $sql = 'SELECT * FROM  sections';
            break;
        case 'students':
            $sql = 'SELECT * FROM  students';
            break;
        case 'test':
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
                GROUP BY 
                    ER.grade
            ';
            break;
    }

    $result = mysqli_query($conn, $sql);

    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $total = $result->num_rows;

    mysqli_free_result($result);

    mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

    <?php include ('templates/header.php');?>

    <section class="container">
        <form method="POST" style="margin: 24px">
            <div class="transparent z-depth-0">
                <button class="btn z-depth-0" name="type" value="students">Students</button>
                <button class="btn z-depth-0" name="type" value="departments">Departments</button>
                <button class="btn z-depth-0" type="submit" name="type" value="professors">Professors</button>
                
                
                <button class="btn z-depth-0" name="type" value="courses">Courses</button>
                <button class="btn z-depth-0" name="type" value="sections">Sections</button>
                <button class="btn z-depth-0" name="type" value="enrollment_records">Enrollment Records</button>
                <button class="btn z-depth-0 warning" name="type" value="test">debug</button>
            </div>
        </form>
        
        <h4 class="grey-text"> Table for: <b> <?php echo htmlspecialchars(ucfirst($type)); ?> </b></h4>
        <h6 class="grey-text">Total Results Found: <b><?php echo $total ?> results</b></h6>
        <hr>
        <table>
            <thead>
                <tr>
                    <?php if (!empty($data)) {
                        // Display table headers based on the first row
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

    </section>

    <?php include ('templates/footer.php');?>
</html>