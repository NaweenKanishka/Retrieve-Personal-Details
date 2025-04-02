<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "company_A";

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
                                <th>Full Name</th>
                                <th>Date of Birth</th>
                                <th>NIC</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Occupation</th>
                                <th>Gender</th>
                                <th>Registered Date</th>
                                <th>Actions</th>
                            </tr>";

        while ($row = $result->fetch_assoc()) {
            $searchResults .= "<tr>
                                <td>{$row['full_name']}</td>
                                <td>{$row['dob']}</td>
                                <td>{$row['nic']}</td>
                                <td>{$row['address']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['occupation']}</td>
                                <td>{$row['gender']}</td>
                                <td>{$row['registered_date']}</td>
                                <td>
                                    <a href='edit.php?id={$row['id']}'>Edit</a> | 
                                    <a href='delete.php?id={$row['id']}'>Delete</a>
                                </td>
                            </tr>";
        }
        $searchResults .= "</table>";
    } else {
        $searchResults = "<p>No residents found matching your search.</p>";
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
            
            <input type="text" name="name" id="name" placeholder="Enter your First or Last Name">
            <button type="submit" name="submit" id="submit">Search</button>
        </div>

       

    </div>
    <div class="result-div">

        <div class="inpt-div">
            
            <input type="text" name="name" id="name" placeholder="Enter your First or Last Name">
            <button type="submit" name="submit" id="submit">Search</button>
        </div>

       

    </div>
   

</body>

</html>