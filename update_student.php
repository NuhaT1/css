<?php
include 'database.php';

$errors = array();
$form_data = array();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ID"])) {
    $ID = $_POST["ID"];

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

    // Display errors and maintain user input
    if (!empty($errors)) {
        // Display errors on the same page
        echo '<div class="error-container"><ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul></div>';
    } else {
        // Get the current timestamp
        $currentTimestamp = date("Y-m-d H:i:s");

        // Update the record in the database
        $sql = "UPDATE registration SET firstname=?, lastname=?, gender=?, birthdate=?, grade=?, schoolName=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $form_data['first_name'], $form_data['last_name'], $form_data['gender'], $form_data['birth_date'], $form_data['grade'], $form_data['school_name'], $ID);
        $stmt->execute();

        echo '<div class="success-container">Record updated successfully.</div>';
        
        // Close the database connection
        $conn->close();

        // Redirect to list page
        header("Location: Student_list.php");
        exit();
    }
} else {
    $errors[] = "Form data is not valid or incomplete.";
}
?>
