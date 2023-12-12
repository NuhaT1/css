<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Listing</title>
    <!-- Include your CSS styles here -->
</head>
<body>
    <h2>Students Listing</h2>

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

    // Fetch student data
    $sql = "SELECT * FROM registration";
    $result = $conn->query($sql);

    // Check for errors during query execution
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        // Display student data in a table
        echo "<table border='1'>
                <tr>
                    <th>firstname</th>
                    <th>lastname</th>
                    <th>gender</th>
                    <th>birthdate</th>
                    <th>grade</th>
                    <th>schoolName</th>
                    <th>Action</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["firstname"] . "</td>
                    <td>" . $row["lastname"] . "</td>
                    <td>" . $row["gender"] . "</td>
                    <td>" . $row["birthdate"] . "</td>
                    <td>" . $row["grade"] . "</td>
                    <td>" . $row["schoolName"] . "</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No students found.";
    }

    // Close the database connection
    $conn->close();
    ?>

</body>
</html>
