<?php

// Include the database connection file
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if form data is present
    if (!empty($_POST['first_name'])) {
        // Retrieve form data
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $grade = mysqli_real_escape_string($conn, $_POST['grade']);
        $school_name = mysqli_real_escape_string($conn, $_POST['school_name']);

        // SQL query to insert data
        $sql = "INSERT INTO registration (ID,first_name, last_name, gender, grade, birth_date, school_name) VALUES ('$ID','$first_name', '$last_name', '$gender', '$grade', '$school_name', '$birth_date')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Form data is incomplete.";
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
