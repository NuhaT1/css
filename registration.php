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

        <label for="birth_date">Date of Birth:</label>
        <input type="date" name="birth_date" required><br>

        <label for="grade">Grade:</label>
        <input type="text" name="grade" required><br>

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
