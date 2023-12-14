<!-- student_list.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information List</title>
    <link rel="stylesheet" href="list.css">
</head>
<body>

    <h2>Student Information List</h2>
    <?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'login_registrarion';
$port = 3306;
$conn = new mysqli($hostname, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve student information
$query = "SELECT * FROM registration ";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<table>
    <tr>
        <th>StudentID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Gender</th>
        <th>Date of Birth</th>
        <th>Grade</th>
        <th>School Name</th>
        <th>Action</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $row['ID'] . '</td>
                    <td>' . $row['firstname'] . '</td>
                    <td>' . $row['lastname'] . '</td>
                    <td>' . $row['gender'] . '</td>
                    <td>' . $row['birthdate'] . '</td>
                    <td>' . $row['grade'] . '</td>
                    <td>' . $row['schoolName'] . '</td>
                        </tr>';
        }
    } else {
        echo "No records found.";
    }

    $conn->close();
    ?>

</table>


</body>
</html>