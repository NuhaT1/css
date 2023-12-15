<!-- update_student.php -->

<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ID"])) {
    $ID = $_POST["ID"];

    // Retrieve form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);

    // Similar input fields for other details

    $sql = "UPDATE registration SET firstname=?, lastname=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $first_name, $last_name, $ID);
    $stmt->execute();

    header("Location: student_list.php");
    exit();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
