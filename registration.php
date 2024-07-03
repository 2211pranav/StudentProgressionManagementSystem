<?php
// Step 1: Establish a connection to the database
include 'conn.php';
// Step 2: Retrieve form data using $_POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['Firstname'];
    $lastname = $_POST['Lastname'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    // Step 3: Sanitize and validate input data (Optional, but highly recommended)
    // For example, you can use mysqli_real_escape_string() or prepared statements for sanitization

    // Step 4: Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Step 5: Insert data into the database table using prepared statements
    $sql = "INSERT INTO registration (Firstname, Lastname, Email, Password) VALUES (?, ?, ?, ?)";
    
    // Prepare and bind the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $firstname, $lastname, $email, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        header("Location: home.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Step 6: Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
