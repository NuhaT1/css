<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $student_id = $_GET["id"];
    $currentDateTime = date('Y-m-d H:i:s');

    // Mark as deleted in the database with a timestamp
    $sql = "UPDATE registration SET is_deleted = 1, deleted_at = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $currentDateTime, $student_id);

    // Execute the statement and check for errors
    if ($stmt->execute()) {
        header("Location: student_list.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
