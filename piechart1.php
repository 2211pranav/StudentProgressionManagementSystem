<?php
// Database connection
include "conn2.php";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch CGPA data from the database
$sql = "SELECT cgpa FROM students";
$result = $conn->query($sql);

// Initialize variables to count pass, average, distinction, and fail
$passCount = 0;
$averageCount = 0;
$distinctionCount = 0;
$failCount = 0;

// Process fetched data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cgpa = $row['cgpa'];
        // Categorize CGPA into pass, average, distinction, and fail
        if ($cgpa < 5) {
            $failCount++;
        } if ($cgpa < 5.5 && $cgpa >=5) {
            $passCount++;
        } if ($cgpa >= 5.5 && $cgpa <=6.9) {
            $averageCount++;
        } if ($cgpa >= 7) {
            $distinctionCount++;
        }
    }
}

// Close connection
$conn->close();
?>