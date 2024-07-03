<?php
// Start session to access session variables
session_start();

// Perform any necessary cleanup or logout actions here
// For example, you might want to unset session variables or destroy the session
// Unset all of the session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the desired page after logout (e.g., login page)
header("Location:login.php"); // Replace "login.php" with the page you want to redirect to
exit(); // Ensure script execution stops after redirection
?>