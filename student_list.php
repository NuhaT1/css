<!-- student_list.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information List</title>
    <link rel="stylesheet" href="list.css">
</head>
<body>

    <h2>Student Information List</h2>
    
    <!-- Add a search form -->
    <form method="GET" action="student_list.php">
        <label for="search">Search by Name or ID:</label>
        <input type="text" id="search" name="search">
        <input type="submit" value="Search">
    </form>

    <!-- Add a filter form for school name -->
    <form method="GET" action="student_list.php">
        <label for="schoolFilter">Filter by School Name:</label>
        <input type="text" id="schoolFilter" name="schoolFilter">
        <input type="submit" value="Filter">
    </form>

    <?php
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'login_registrarion';
    $port = 3306;
    $conn = new mysqli($hostname, $username, $password, $database, $port);

    // Number of records per page
    $recordsPerPage = 3;

    // Get the search query if submitted
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Get the school filter if submitted
    $schoolFilter = isset($_GET['schoolFilter']) ? $_GET['schoolFilter'] : '';

    // Append the search condition to the SQL query if a search is performed
    $sqlSelect = "SELECT * FROM registration WHERE is_deleted = 0";
    if (!empty($search)) {
        $sqlSelect .= " AND (firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR ID = '$search')";
    }

    // Append the school filter condition to the SQL query if a filter is applied
    if (!empty($schoolFilter)) {
        $sqlSelect .= " AND schoolName LIKE '%$schoolFilter%'";
    }

    $sqlCount = "SELECT COUNT(ID) AS total FROM registration WHERE is_deleted = 0";
    $resultCount = $conn->query($sqlCount);
    $rowCount = $resultCount->fetch_assoc();
    $totalPages = ceil($rowCount['total'] / $recordsPerPage);

    // Get the current page number
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    // Calculate the starting record for the current page
    $startFrom = ($page - 1) * $recordsPerPage;

    $sqlSelect .= " LIMIT ?, ?";
    $stmt = $conn->prepare($sqlSelect);
    $stmt->bind_param("ii", $startFrom, $recordsPerPage);
    $stmt->execute();
    $result = $stmt->get_result();

    // Query to retrieve student information
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    ?>

    <table>
        <tr>
            <th>StudentID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Date of Birth</th>
            <th>Grade</th>
            <th>School Name</th>
            <th>Action</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['ID'] . '</td>
                        <td>' . $row['firstname'] . '</td>
                        <td>' . $row['lastname'] . '</td>
                        <td>' . $row['gender'] . '</td>
                        <td>' . $row['birthdate'] . '</td>
                        <td>' . $row['grade'] . '</td>
                        <td>' . $row['schoolName'] . '</td>
                        <td>
                                <a href="view_student.php?id=' . $row['ID'] . '">View</a>
                                <a href="edit_student.php?id=' . $row['ID'] . '">Edit</a>
                                <a href="delete_student.php?id=' . $row['ID'] . '" onclick="return confirm(\'Are you sure you want to delete this student?\')">Delete</a>
                            </td>   
                        </tr>';
            }
        } else {
            echo "No records found.";
        }
        ?>
    </table>

    <!-- Pagination links -->
    <div class='pagination'>
        <?php
        
        // Next link for pages beyond 1
        if ($page > 1) {
            $prevPage = $page - 1;
            echo "<a href='student_list.php?page=$prevPage&search=$search&schoolFilter=$schoolFilter'>Previous</a> ";
        }

            // Display the current page number
            echo "Page $page ";


        if ($page < $totalPages) {
            $nextPage = $page + 1;
            echo "<a href='student_list.php?page=$nextPage&search=$search&schoolFilter=$schoolFilter'>Next</a>";
        }
        ?>
    </div>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
