<?php
// Include the database connection file
include 'database.php';

// Initialize an array to store error messages and form data
$errors = array();
$form_data = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $form_data['first_name'] = mysqli_real_escape_string($conn, $_POST['first_name']);
    $form_data['last_name'] = mysqli_real_escape_string($conn, $_POST['last_name']);
    $form_data['birth_date'] = mysqli_real_escape_string($conn, $_POST['birth_date']);
    $form_data['gender'] = mysqli_real_escape_string($conn, $_POST['gender']);
    $form_data['grade'] = mysqli_real_escape_string($conn, $_POST['grade']);
    $form_data['school_name'] = mysqli_real_escape_string($conn, $_POST['schoolName']);

    // Validate names contain only alphabetical characters
    if (!ctype_alpha($form_data['first_name'])) {
        $errors['first_name'] = "First names should only contain alphabetical characters.";
    }

    if (!ctype_alpha($form_data['last_name'])) {
        $errors['last_name'] = "Last names should only contain alphabetical characters.";
    }

    // Capitalize the first letter of the first name and last name
    $form_data['first_name'] = ucfirst($form_data['first_name']);
    $form_data['last_name'] = ucfirst($form_data['last_name']);

    // Validate grade contains only numeric characters and is in the range of 1 to 12
    if (!is_numeric($form_data['grade']) || $form_data['grade'] < 1 || $form_data['grade'] > 12) {
        $errors['grade'] = "Grade must be a numeric value between 1 and 12.";
    } else {
        // Convert $grade to an integer to remove any decimal places
        $form_data['grade'] = (int)$form_data['grade'];

        // Check if the converted $grade is still in the valid range
        if ($form_data['grade'] < 1 || $form_data['grade'] > 12) {
            $errors['grade'] = "Grade must be a numeric value between 1 and 12.";
        }
    }
}
 // Check if form data is complete
 if (empty($errors)) {
    // If there are no errors, proceed with database insertion
    // Get the current timestamp
    $currentTimestamp = date("Y-m-d H:i:s");

    // SQL query to insert data using prepared statement
    $sqlInsert = "INSERT INTO registration (firstname, lastname, gender, grade, birthdate, schoolName, registrationTimestamp) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sqlInsert);

    // Bind parameters
    $stmt->bind_param("sssssss", $form_data['first_name'], $form_data['last_name'], $form_data['gender'], $form_data['grade'], $form_data['birth_date'], $form_data['school_name'], $currentTimestamp);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the list page after successful insertion
        header("Location: student_list.php");
        exit();
    } 

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="styles.css">
    <script src="validateDate.js"></script>
</head>
<body>

<div class="container">
    <h2>Student Registration</h2>
    <form action="registration.php" method="post" onsubmit="return validateDate();">
    
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?php echo isset($form_data['first_name']) ? $form_data['first_name'] : ''; ?>" required>
        <?php
            if (isset($errors['first_name'])) {
                echo '<span class="error">' . $errors['first_name'] . '</span>';
            }
        ?><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?php echo isset($form_data['last_name']) ? $form_data['last_name'] : ''; ?>" required>
        <?php
            if (isset($errors['last_name'])) {
                echo '<span class="error">' . $errors['last_name'] . '</span>';
            }
        ?><br>

        <h2>Select Gender</h2>

        <label>
            <input type="radio" name="gender" value="M" <?php echo (isset($form_data['gender']) && $form_data['gender'] === 'M') ? 'checked' : ''; ?> required>
            Male
        </label>
        <label>
            <input type="radio" name="gender" value="F" <?php echo (isset($form_data['gender']) && $form_data['gender'] === 'F') ? 'checked' : ''; ?> required>
            Female
        </label>
        <?php
            if (isset($errors['gender'])) {
                echo '<span class="error">' . $errors['gender'] . '</span>';
            }
        ?><br>

        <label for="birth_date">Date of Birth:</label>
        <input type="date" name="birth_date" id="birth_date" value="<?php echo isset($form_data['birth_date']) ? $form_data['birth_date'] : ''; ?>" required>
        <?php
            if (isset($errors['birth_date'])) {
                echo '<span class="error">' . $errors['birth_date'] . '</span>';
            }
        ?><br>

        <label for="grade">Grade:</label>

        <input type="number" name="grade" value="<?php echo isset($form_data['grade']) ? $form_data['grade'] : ''; ?>" required>
        <?php
            if (isset($errors['grade'])) {
                echo '<span class="error">' . $errors['grade'] . '</span>';
            }
        ?><br>

        <label for="schoolName">School Name:</label>
        <select name="schoolName" required>
            <option value="Bole School" <?php echo (isset($form_data['school_name']) && $form_data['school_name'] === 'Bole School') ? 'selected' : ''; ?>>Bole School</option>
            <option value="Lideta School" <?php echo (isset($form_data['school_name']) && $form_data['school_name'] === 'Lideta School')? 'selected' : ''; ?>>Lideta School</option>
            <option value="Menilik School" <?php echo (isset($form_data['school_name']) && $form_data['school_name'] === 'Menilik School') ? 'selected' : ''; ?>>Menilik School</option>
            <option value="Akaki School" <?php echo (isset($form_data['school_name']) && $form_data['school_name'] === 'Akaki School') ? 'selected' : ''; ?>>Akaki School</option>
            <option value="Arada School" <?php echo (isset($form_data['school_name']) && $form_data['school_name'] === 'Arada School') ? 'selected' : ''; ?>>Arada School</option>
        </select>
        <?php
            if (isset($errors['school_name'])) {
                echo '<span class="

                error">' . $errors['school_name'] . '</span>';
            }
        ?><br>

        <input type="submit" value="Register">
    </form>
  </div>
</body>
</html>
