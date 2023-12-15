<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <link rel="stylesheet" href="list.css">

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
        $sql = "SELECT * FROM registration WHERE ID= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $lastInsertedId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Display student data in a table
           echo "<h2>Student Details</h2>";
           echo "<table>";
           echo "<tr><th>Attribute</th><th>Value</th></tr>";
           echo "<tr><td>First Name</td><td>" . $row["firstname"] . "</td></tr>";
           echo "<tr><td>Last Name</td><td>" . $row["lastname"] . "</td></tr>";
           echo "<tr><td>Gender</td><td>" . $row["gender"] . "</td></tr>";
           echo "<tr><td>Date of Birth</td><td>" . $row["birthdate"] . "</td></tr>";
           echo "<tr><td>Grade</td><td>" . $row["grade"] . "</td></tr>";
           echo "<tr><td>School Name</td><td>" . $row["schoolName"] . "</td></tr>";
           echo "</table>";

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
