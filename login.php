<?php
// Establish database connection (replace with your database credentials)
include 'conn.php';

// Retrieve username from form submission
if(isset($_POST['submit'])) {
    // Using prepared statements to prevent SQL injection
    $username = $_POST['Email'];
    $password = $_POST['password'];

    // Prepare SQL statement
    $sql = "SELECT * FROM registration WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("ss", $username, $password);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // User exists in the database
        header("Location: home.php");
    } else {
        // User does not exist in the database
        echo "User does not exist!";
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>
