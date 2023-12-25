<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $student_id = $_GET["id"];

    // Mark as deleted in the database without a timestamp
    $sql = "UPDATE registration SET is_deleted = 1 WHERE id = ?";
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
