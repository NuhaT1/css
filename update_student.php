<!-- update_student.php -->

<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ID"])) {
    $ID = $_POST["ID"];

    // Retrieve form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);
    $school_Name = mysqli_real_escape_string($conn, $_POST['schoolName']);

    // Update the record in the database
    $sql = "UPDATE registration SET firstname=?, lastname=?, gender=?, birthdate=?, grade=?, schoolName=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $first_name, $last_name, $gender, $birth_date, $grade, $school_Name, $ID);
    $stmt->execute();

    header("Location: student_list.php");
    exit();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
