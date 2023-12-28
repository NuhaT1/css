<?php
include 'database.php';

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ID"])) {
    $ID = $_POST["ID"];

    // Retrieve form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);
    $school_Name = mysqli_real_escape_string($conn, $_POST['schoolName']);

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
    }

    // Calculate age
    $currentDate = new DateTime();
    $registrationDate = new DateTime($birth_date);
    $yearsDifference = $currentDate->diff($registrationDate)->y;

    if ($yearsDifference > 4) {
        $errors[] = "Invalid age. Students must be 4 years or younger.";
    }

    // Display errors and maintain user input
    if (!empty($errors)) {
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
        $stmt->bind_param("ssssssi", $first_name, $last_name, $gender, $birth_date, $grade, $school_Name, $ID);
        $stmt->execute();

        header("Location: student_list.php");
        exit();
    }
} else {
    $errors[] = "Form data is not valid or incomplete.";
}

$conn->close();
?>
