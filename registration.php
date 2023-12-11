<?php

// Include the database connection file
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if form data is present
    if (
        isset($_POST['ID'], $_POST['first_name'], $_POST['last_name'], $_POST['birth_date'], $_POST['gender'], $_POST['grade'], $_POST['school_name'])
        && !empty($_POST['ID']) && !empty($_POST['first_name']) && !empty($_POST['last_name'])
        && !empty($_POST['birth_date']) && !empty($_POST['gender']) && !empty($_POST['grade']) && !empty($_POST['school_name'])
    ) {
        // Retrieve form data
        $ID = mysqli_real_escape_string($conn, $_POST['ID']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $grade = mysqli_real_escape_string($conn, $_POST['grade']);
        $school_name = mysqli_real_escape_string($conn, $_POST['school_name']);

        // Validate data 
        if (!is_numeric($ID)) {
            echo "Error: ID must be a numeric value.";
            exit();
        }
// Validate date format (assuming YYYY-MM-DD format)
if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $birth_date)) {
    echo "Error: Invalid date format. Please use YYYY-MM-DD.";
    exit();
}
// Validate names contain only alphabetical characters
    if (!ctype_alpha($first_name) || !ctype_alpha($last_name)) {
        echo "Error: First and last names should only contain alphabetical characters.";
        exit()
    }
    // Validate grade contains only numeric characters
        if (!is_numeric($grade)) {
            echo "Error: Grade must be a numeric value.";
            exit();
        }
        // SQL query to insert data
        $sql = "INSERT INTO registration (ID, firstname, lastname, gender, grade, birthdate, schoolname) 
                VALUES ('$ID', '$first_name', '$last_name', '$gender', '$grade', '$birth_date', '$school_name')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
     else {
        echo "Form data is incomplete or invalid.";
    }
 else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
