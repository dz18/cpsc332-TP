
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

    // Write Query for all students
    $sql = 'SELECT * FROM  students';

    // Make query and get result
    $result = mysqli_query($conn, $sql);

    // Fetch resulting rows as an array
    $students = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Free result from memory
    mysqli_free_result($result);

    // Close connection
    mysqli_close($conn);

    print_r($students);
?>

<!DOCTYPE html>
<html lang="en">
    <?php include ('templates/header.php');?>

    <?php include ('templates/footer.php');?>
</html>