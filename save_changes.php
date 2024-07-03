<?php
include("conn.php"); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $degree = $_POST['deg'];
    $data = $_POST['data'];

    foreach ($data as $index => $row) {
        $ay = htmlspecialchars($row[0]);
        $fy_admitted_regular = htmlspecialchars($row[1]);
        $fy_admitted_dsy = htmlspecialchars($row[2]);
        $sy_admitted_regular = htmlspecialchars($row[3]);
        $sy_admitted_dsy = htmlspecialchars($row[4]);
        $ty_admitted_regular = htmlspecialchars($row[5]);
        $ty_admitted_dsy = htmlspecialchars($row[6]);
        $bt_admitted_regular = htmlspecialchars($row[7]);
        $bt_admitted_dsy = htmlspecialchars($row[8]);
        $bt_passed_regular = htmlspecialchars($row[9]);
        $bt_passed_dsy = htmlspecialchars($row[10]);

        // Check if the row already exists in the database
        $query = $conn->prepare("SELECT * FROM degreedata WHERE degree_name = ? AND ay = ?");
        $query->bind_param("ss", $degree, $ay);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            // Update the existing row
            $query = $conn->prepare("UPDATE degreedata SET fy_admitted_regular = ?, fy_admitted_dsy = ?, sy_admitted_regular = ?, sy_admitted_dsy = ?, ty_admitted_regular = ?, ty_admitted_dsy = ?, bt_admitted_regular = ?, bt_admitted_dsy = ?, bt_passed_regular = ?, bt_passed_dsy = ? WHERE degree_name = ? AND ay = ?");
            $query->bind_param("iiiiiiiiiiis", $fy_admitted_regular, $fy_admitted_dsy, $sy_admitted_regular, $sy_admitted_dsy, $ty_admitted_regular, $ty_admitted_dsy, $bt_admitted_regular, $bt_admitted_dsy, $bt_passed_regular, $bt_passed_dsy, $degree, $ay);
        } else {
            // Insert a new row
            $query = $conn->prepare("INSERT INTO degreedata (degree_name, ay, fy_admitted_regular, fy_admitted_dsy, sy_admitted_regular, sy_admitted_dsy, ty_admitted_regular, ty_admitted_dsy, bt_admitted_regular, bt_admitted_dsy, bt_passed_regular, bt_passed_dsy) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $query->bind_param("ssiiiiiiiiii", $degree, $ay, $fy_admitted_regular, $fy_admitted_dsy, $sy_admitted_regular, $sy_admitted_dsy, $ty_admitted_regular, $ty_admitted_dsy, $bt_admitted_regular, $bt_admitted_dsy, $bt_passed_regular, $bt_passed_dsy);
        }

        // Execute the query
        if (!$query->execute()) {
            echo "Error: " . $query->error;
        }
    }

    // Redirect back to the form page
    header("Location: degree.php?name=" . urlencode($degree));
    exit();
}
?>
