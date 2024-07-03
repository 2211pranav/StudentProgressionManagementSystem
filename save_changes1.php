<?php
session_start();
include("conn.php"); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dip = $_POST['dip'];
    $data = $_POST['data'];
    $update_row = $_POST['update_row'];

    // Loop through the data and update or insert rows
    foreach ($data as $index => $row) {
        if (!empty($row[0])) { // Ensure the row is not empty
            $ay = htmlspecialchars($row[0]);
            $fy_admitted_regular = htmlspecialchars($row[1]);
            $fy_admitted_dsy = htmlspecialchars($row[2]);
            $sy_admitted_regular = htmlspecialchars($row[3]);
            $sy_admitted_dsy = htmlspecialchars($row[4]);
            $ty_admitted_regular = htmlspecialchars($row[5]);
            $ty_admitted_dsy = htmlspecialchars($row[6]);
            $ty_passed_regular = htmlspecialchars($row[7]);
            $ty_passed_dsy = htmlspecialchars($row[8]);

            // Check if the record for the AY and degree already exists
            $query = $conn->prepare("SELECT * FROM diplomadata WHERE ay = ? AND diploma_name = ?");
            $query->bind_param("ss", $ay, $dip);
            $query->execute();
            $result = $query->get_result();

            if ($result->num_rows > 0) {
                // Update the existing record
                $query = $conn->prepare("UPDATE diplomadata SET fy_admitted_regular = ?, fy_admitted_dsy = ?, sy_admitted_regular = ?, sy_admitted_dsy = ?, ty_admitted_regular = ?, ty_admitted_dsy = ?, ty_passed_regular = ?, ty_passed_dsy = ? WHERE ay = ? AND diploma_name = ?");
                $query->bind_param("iiiiiiiiss", $fy_admitted_regular, $fy_admitted_dsy, $sy_admitted_regular, $sy_admitted_dsy, $ty_admitted_regular, $ty_admitted_dsy, $ty_passed_regular, $ty_passed_dsy, $ay, $dip);
            } else {
                // Insert a new record
                $query = $conn->prepare("INSERT INTO diplomadata (ay, diploma_name, fy_admitted_regular, fy_admitted_dsy, sy_admitted_regular, sy_admitted_dsy, ty_admitted_regular, ty_admitted_dsy, ty_passed_regular, ty_passed_dsy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $query->bind_param("ssiiiiiiii", $ay, $dip, $fy_admitted_regular, $fy_admitted_dsy, $sy_admitted_regular, $sy_admitted_dsy, $ty_admitted_regular, $ty_admitted_dsy, $ty_passed_regular, $ty_passed_dsy);
            }

            // Execute the query and check for errors
            if (!$query->execute()) {
                echo "Error: " . $query->error;
            }
        }
    }
}

// Redirect back to the diploma.php page after saving changes
header("Location: diploma.php?name=" . urlencode($dip));
exit();
?>
