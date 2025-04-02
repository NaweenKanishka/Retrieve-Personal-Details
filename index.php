<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "company_a";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$searchResults = "";

// Check if search form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $search = trim($_POST['search']);

    // Prevent SQL injection
    $search = $conn->real_escape_string($search);

    // Search query (Search by NIC or Name)
    $sql = "SELECT * FROM employee WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $searchResults .= "<table border='1'>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Date of Birth</th>
                                <th>Designation</th>
                                <th>Start Date</th>
                                <th>Salary</th>
                                <th>Branch</th>
                            </tr>";

        while ($row = $result->fetch_assoc()) {
            $searchResults .= "<tr>
                                <td>{$row['ID']}</td> 
                                <td>{$row['first_name']}</td>
                                <td>{$row['last_name']}</td>
                                <td>{$row['date_of_birth']}</td>
                                <td>{$row['designation']}</td>
                                <td>{$row['start_date']}</td>
                                <td>{$row['salary']}</td>
                                <td>{$row['branch']}</td>
                            </tr>";
        }
        $searchResults .= "</table>";
    } else {
        $searchResults = "<p>No employees found matching your search.</p>";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrieve Personal Details</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="body-container">
        <div class="inpt-div">
            <!-- Add a form to handle search -->
            <form method="POST" action="">
                <input type="text" name="search" id="search" placeholder="Enter your First or Last Name">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    <div id="result-div">
        <?php echo $searchResults; ?>
    </div>

</body>

</html>
