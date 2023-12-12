
<?php

// Include the database connection file
include 'database.php';

// Initialize an array to store error messages
$errors = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if form data is present

    if (
        isset($_POST['first_name'], $_POST['last_name'], $_POST['birthdate'], $_POST['gender'], $_POST['grade'], $_POST['schoolname'])
        && !empty($_POST['first_name']) && !empty($_POST['last_name'])
        && !empty($_POST['birthdate']) && !empty($_POST['gender']) && !empty($_POST['grade']) && !empty($_POST['schoolname'])
    ) {
        // Retrieve form data
        $firstname = mysqli_real_escape_string($conn, $_POST['first_name']);
        $lastname = mysqli_real_escape_string($conn, $_POST['last_name']);
        $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $grade = mysqli_real_escape_string($conn, $_POST['grade']);
        $schoolname = mysqli_real_escape_string($conn, $_POST['schoolname']);

        // Validate names contain only alphabetical characters
        if (!ctype_alpha($firstname) || !ctype_alpha($lastname)) {
            $errors[] = "First and last names should only contain alphabetical characters.";
        }

        // Validate grade contains only numeric characters
        if (!is_numeric($grade)) {
            $errors[] = "Grade must be a numeric value.";
        }

        // Validate date format (assuming YYYY-MM-DD format)
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $birthdate)) {
            $errors[] = "Invalid date format. Please use YYYY-MM-DD.";
        }

        // If there are no errors, proceed with database insertion
        if (empty($errors)) {
            // SQL query to insert data
            $sql = "INSERT INTO registration (firstname, lastname, gender, grade, birthdate, schoolname) 
                    VALUES ('$firstname', '$lastname', '$gender', '$grade', '$birthdate', '$schoolname')";

            if ($conn->query($sql) === TRUE) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        $errors[] = "Form data is incomplete or invalid.";
    }
} else {
    $errors[] = "Invalid request.";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <!-- Other head elements -->
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <h2>Student Registration</h2>

    <?php
    // Display error messages
    if (!empty($errors)) {
        echo '<div class="error-container"><ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul></div>';
    }
    ?>

    <form action="registration.php" method="post">

        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" required><br>

        <h2>Select Gender</h2>
    <form action="registration.php" method="post">
        <label>
            <input type="radio" name="gender" value="male" required>
            Male
        </label>

        <label>
            <input type="radio" name="gender" value="female" required>
            Female
        </label>

        <label for="birthdate">Date of Birth:</label>
        <input type="date" name="birthdate" required><br>

        <label for="grade">Grade:</label>
        <input type="text" name="grade" required><br>

        <label for="schoolName">School Name:</label>
        <select name="schoolName" required>
            <option value="Bole School">Bole School</option>
            <option value="Lideta School">Lideta School</option>
            <option value="Menilik School">Menilik School</option>
            <option value="Akaki School">Akaki School</option>
            <option value="Arada School">Arada School</option>
        </select><br>

        <input type="submit" value="Register">
    </form>
</body>

</html>
