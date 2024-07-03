<?php
// Database connection
include 'conn2.php';
// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $prn = $_POST['prn'];
    $cgpa = $_POST['cgpa'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $course = $_POST['course'];
    $year = $_POST['year'];

    // SQL to insert data into table
    $sql = "INSERT INTO students (name, email, prn, cgpa, gender, dob, course, year)
    VALUES ('$name', '$email', '$prn', '$cgpa', '$gender', '$dob', '$course', '$year')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful, redirect to new.html
        echo "<script>alert('Registration saved successfully');</script>";
        echo "<script>window.location.href = 'new.html';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
