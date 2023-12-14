<!-- view_student.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <link rel="stylesheet" href="list.css">
</head>
<body>

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

if (isset($_GET["id"])) {
    $student_id = $_GET["id"];

    $sql = "SELECT * FROM registration WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h2>Student Details</h2>";
        echo "<p>First Name: " . $row["firstname"] . "</p>";
        echo "<p>Last Name: " . $row["lastname"] . "</p>";
        echo "<p>Gender: " . $row["gender"] . "</p>";
        echo "<p>Date of Birth: " . $row["birthdate"] . "</p>";
        echo "<p>Grade: " . $row["grade"] . "</p>";
        echo "<p>School Name: " . $row["schoolName"] . "</p>";

        // Edit and Delete buttons
        echo '<form action="edit_student.php" method="get">
                <input type="hidden" name="id" value="' . $row["ID"] . '">
                <input type="submit" value="Edit">
              </form>';
        echo '<form action="delete_student.php" method="post" onsubmit="return confirm(\'Are you sure you want to delete this student?\')">
                <input type="hidden" name="id" value="' . $row["ID"] . '">
                <input type="submit" value="Delete">
              </form>';
    } else {
        echo "Student not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>

</body>
</html>
