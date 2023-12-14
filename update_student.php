<!-- update_student.php -->

<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $student_id = $_POST["id"];

    // Retrieve form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);

    // Similar input fields for other details

    $sql = "UPDATE registration SET firstname=?, lastname=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $first_name, $last_name, $student_id);
    $stmt->execute();

    header("Location: student_list.php");
    exit();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
