<!-- view_student.php -->

<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $student_id = $_GET["id"];

    $sql = "SELECT * FROM registration WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
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
    echo "Invalid request.";
}

$conn->close();
?>
