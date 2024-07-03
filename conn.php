<?php 
  $servername = "localhost"; // Change this to your MySQL server address
  $username = "root"; // Change this to your MySQL username
  $password = ""; // Change this to your MySQL password
  $dbname = "studentprogression"; // Change this to your MySQL database name

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
?>