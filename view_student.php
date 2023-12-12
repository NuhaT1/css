<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <!-- Include your CSS styles here -->
</head>
<body>

    <?php
    // Retrieve student data from the database (replace these credentials with your own)
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'login_registrarion';
    // Create a connection
    $conn = new mysqli($hostname, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch student data based on the provided ID
    if (isset($_GET["id"])) {
        $student_id = $_GET["id"];
        $sql = "SELECT * FROM registration WHERE id = $student_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display student data
            $row = $result->fetch_assoc();
            echo "<h2>Student Details</h2>";
            echo "<p>First Name: " . $row["firstname"] . "</p>";
            echo "<p>Last Name: " . $row["lastname"] . "</p>";
            echo "<p>Gender: " . $row["gender"] . "</p>";
            echo "<p>Date of Birth: " . $row["birthdate"] . "</p>";
            echo "<p>Grade: " . $row["grade"] . "</p>";
            echo "<p>School Name: " . $row["schoolName"] . "</p>";
        } else {
            echo "Student not found.";
        }
    } else {
        echo "Invalid request.";
    }

    // Close the database connection
    $conn->close();
    ?>

</body>
</html>
