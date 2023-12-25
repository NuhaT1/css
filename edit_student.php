<!-- edit_student.php -->

<?php
include 'database.php'; // Ensure you include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $student_id = $_GET["id"];

    $sql = "SELECT * FROM registration WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display student data in a form for editing
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Student</title>
            <link rel="stylesheet" href="styles.css">
        </head>

        <body>
            <h2>Edit Student</h2>

            <form action="update_student.php" method="post">
                <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">

                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" value="<?php echo $row['firstname']; ?>" required><br>

                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" value="<?php echo $row['lastname']; ?>" required><br>

                
        <h2>Select Gender</h2>
    
    <label>
        <input type="radio" name="gender" value="M"<?php echo $row['gender']; ?>" required>
        Male
    </label>

    <label>
        <input type="radio" name="gender" value="F" <?php echo $row['gender']; ?>" required>
        Female
    </label>

    <label for="birth_date">Date of Birth:</label>
    <input type="date" name="birth_date" <?php echo $row['birthdate']; ?>" required><br>

    <label for="grade">Grade:</label>
    <input type="text" name="grade" <?php echo $row['grade']; ?>" required><br>

    <label for="school_name">School Name:</label>
    <select name="schoolName" required>
        <option value="Bole School" <?php if ($row['schoolName'] == 'Bole School') echo 'selected'; ?>>Bole School</option>
        <option value="Lideta School" <?php if ($row['schoolName'] == 'Lideta School') echo 'selected'; ?>>Lideta School</option>
        <option value="Menilik School" <?php if ($row['schoolName'] == 'Menilik School') echo 'selected'; ?>>Menilik School</option>
        <option value="Akaki School" <?php if ($row['schoolName'] == 'Akaki School') echo 'selected'; ?>>Akaki School</option>
        <option value="Arada School" <?php if ($row['schoolName'] == 'Arada School') echo 'selected'; ?>>Arada School</option>
    </select><br>

                <!-- Similar input fields for other details -->

                <input type="submit" value="Update">
            </form>
        </body>
        </html>
<?php
    } else {
        echo "Student not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
