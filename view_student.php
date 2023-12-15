<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <link rel="stylesheet" href="view.css">

</head>
<body>
      <div class="container">
    <?php
    // Retrieve student data from the database (replace these credentials with your own)
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'login_registrarion';
    $port = 3306;
    // Create a connection
    $conn = new mysqli($hostname, $username, $password, $database, $port);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the ID of the last inserted student
    $sql = "SELECT id FROM registration ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastInsertedId = $row['id'];

        // Use the retrieved ID to fetch student details
        $sql = "SELECT * FROM registration WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $lastInsertedId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Display student data
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
        echo "No students found.";
    }

    // Close the database connection
    $conn->close();
    ?>
        </div>  
</body>
</html>
