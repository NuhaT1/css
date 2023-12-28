<?php
// Include the database connection file
include 'database.php';

// Initialize an array to store error messages
$errors = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if form data is present
    if (
        isset($_POST['first_name'], $_POST['last_name'], $_POST['birth_date'], $_POST['gender'], $_POST['grade'], $_POST['school_name'])
        && !empty($_POST['first_name']) && !empty($_POST['last_name'])
        && !empty($_POST['birth_date']) && !empty($_POST['gender']) && !empty($_POST['grade']) && !empty($_POST['school_name'])
    ) {
        // Retrieve form data
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $grade = mysqli_real_escape_string($conn, $_POST['grade']);
        $school_name = mysqli_real_escape_string($conn, $_POST['school_name']);

        // Validate names contain only alphabetical characters
        if (!ctype_alpha($first_name) || !ctype_alpha($last_name)) {
            $errors[] = "First and last names should only contain alphabetical characters.";
        }

        // Capitalize the first letter of the first name and last name
        $first_name = ucfirst($first_name);
        $last_name = ucfirst($last_name);

        // Validate grade contains only numeric characters and is in the range of 1 to 12
        if (!is_numeric($grade) || $grade < 1 || $grade > 12) {
            $errors[] = "Grade must be a numeric value between 1 and 12.";
        } else {
            // Convert $grade to an integer to remove any decimal places
            $grade = (int)$grade;

            // Check if the converted $grade is still in the valid range
            if ($grade < 1 || $grade >12) {
                $errors[] = "Grade must be a numeric value between 1 and 12.";
            }
        }

        // Calculate age
        $currentDate = new DateTime();
        $registrationDate = new DateTime($birth_date);
        $yearsDifference = $currentDate->diff($registrationDate)->y;

        if ($yearsDifference > 4) {
            $errors[] = "Invalid age. Students must be 4 years or younger.";
        }
    } else {
        $errors[] = "Form data is not valid or incomplete.";
    }

    // Display errors and maintain user input
    if (!empty($errors)) {
        echo '<div class="error-container"><ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul></div>';
    } else {
        // If there are no errors, proceed with database insertion
        // Get the current timestamp
        $currentTimestamp = date("Y-m-d H:i:s");

        // SQL query to insert data using prepared statement
        $sqlInsert = "INSERT INTO registration (firstname, lastname, gender, grade, birthdate, schoolName, registrationTimestamp) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = $conn->prepare($sqlInsert);

        // Bind parameters
        $stmt->bind_param("sssssss", $first_name, $last_name, $gender, $grade, $birth_date, $school_name, $currentTimestamp);

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to the list page after successful insertion
            header("Location: student_list.php");
            exit();
        } else {
            echo "Error inserting record: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
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
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="styles4.css">
    <link rel="stylesheet" href="list.css">
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
        <label>
            <input type="radio" name="gender" value="M" required>
            Male
        </label>

        <label>
            <input type="radio" name="gender" value="F" required>
            Female
        </label>

        <label for="birth_date">Date of Birth:</label>
        <input type="date" name="birth_date" required><br>

        <label for="grade">Grade:</label>
        <input type="number" name="grade" min="1" max="12" required><br>

        <label for="school_name">School Name:</label>
        <select name="school_name" required>
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