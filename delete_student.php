<!-- delete_student.php -->

<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $student_id = $_GET["id"];

    $sql = "DELETE FROM registration WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();

    header("Location: student_list.php");
    exit();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
