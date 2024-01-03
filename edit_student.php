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

    if (isset($_GET['errors'])) {
        $errors = unserialize(urldecode($_GET['errors']));
    }

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
            <script src="validateDate.js"></script>
        </head>

        <body>
            <div class="container">
                <h2>Edit Student</h2>

                <form action="update_student.php" method="post" onsubmit="return validateDate();">
                    <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">

                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" value="<?php echo $row['firstname']; ?>" required>
                    <?php
                    if (isset($errors['first_name'])) {
                        echo '<span class="error">' . $errors['first_name'] . '</span>';
                    }
                    ?><br>

                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" value="<?php echo $row['lastname']; ?>" required>
                    <?php
                    if (isset($errors['last_name'])) {
                        echo '<span class="error">' . $errors['last_name'] . '</span>';
                    }
                    ?><br>

                    <h2>Select Gender</h2>

                    <label>
                        <input type="radio" name="gender" value="M" <?php echo ($row['gender'] == 'M') ? 'checked' : ''; ?> required>
                        Male
                    </label>

                    <label>
                        <input type="radio" name="gender" value="F" <?php echo ($row['gender'] == 'F') ? 'checked' : ''; ?> required>
                        Female
                    </label>
                    <?php
                    if (isset($errors['gender'])) {
                        echo '<span class="error">' . $errors['gender'] . '</span>';
                    }
                    ?><br>

                    <label for="birth_date">Date of Birth:</label>
                    <input type="date" name="birth_date" id="birth_date" value="<?php echo $row['birthdate']; ?>" required>
                    <?php
                    if (isset($errors['birth_date'])) {
                        echo '<span class="error">' . $errors['birth_date'] . '</span>';
                    }
                    ?><br>

                    <label for="grade">Grade:</label>
                    <input type="number" name="grade" value="<?php echo $row['grade']; ?>" required>
                    <?php
                    if (isset($errors['grade'])) {
                        echo '<span class="error">' . $errors['grade'] . '</span>';
                    }
                    ?><br>

                    <label for="school_name">School Name:</label>
                    <select name="schoolName" required>
                        <option value="Bole School" <?php if ($row['schoolName'] == 'Bole School') echo 'selected'; ?>>Bole School</option>
                        <option value="Lideta School" <?php if ($row['schoolName'] == 'Lideta School') echo 'selected'; ?>>Lideta School</option>
                        <option value="Menilik School" <?php if ($row['schoolName'] == 'Menilik School') echo 'selected'; ?>>Menilik School</option>
                        <option value="Akaki School" <?php if ($row['schoolName'] == 'Akaki School') echo 'selected'; ?>>Akaki School</option>
                        <option value="Arada School" <?php if ($row['schoolName'] == 'Arada School') echo 'selected'; ?>>Arada School</option>
                    </select>
                    <?php
                    if (isset($errors['school_name'])) {
                        echo '<span class="error">' . $errors['school_name'] . '</span>';
                    }
                    ?><br>

                    <input type="submit" value="Update">
                </form>
            </div>
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
