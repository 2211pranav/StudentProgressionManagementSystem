<?php
// Database connection
include 'conn2.php';

if ($_FILES["csvFile"]["error"] == 0) {
    $filename = $_FILES["csvFile"]["tmp_name"];

    // Read the file
    if (($handle = fopen($filename, "r")) !== false) {
        // Skip the first row if it contains headers
        fgetcsv($handle);

        // Prepare the SQL statements for inserting and updating
        $insertStmt = $conn->prepare("INSERT INTO students (name, email, prn, cgpa, gender, dob, course, year, SEM_I, SEM_II, SEM_III, SEM_IV, SEM_V, SEM_VI, SEM_VII, SEM_VIII) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $updateStmt = $conn->prepare("UPDATE students SET name=?, email=?, cgpa=?, gender=?, dob=?, course=?, year=?, SEM_I=?, SEM_II=?, SEM_III=?, SEM_IV=?, SEM_V=?, SEM_VI=?, SEM_VII=?, SEM_VIII=? WHERE prn=?");

        // Bind parameters for both statements
        $insertStmt->bind_param("ssssssssssssssss", $name, $email, $prn, $cgpa, $gender, $dob, $course, $year, $SEM_I, $SEM_II, $SEM_III, $SEM_IV, $SEM_V, $SEM_VI, $SEM_VII, $SEM_VIII);
        $updateStmt->bind_param("ssssssssssssssss", $name, $email, $prn,$cgpa, $gender, $dob, $course, $year, $SEM_I, $SEM_II, $SEM_III, $SEM_IV, $SEM_V, $SEM_VI, $SEM_VII, $SEM_VIII);

        // Read and process data row by row
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $name = $data[0];
            $email = $data[1];
            $prn = $data[2];
            $cgpa = $data[3];
            $gender = $data[4];
            $dob = $data[5];
            $course = $data[6];
            $year = $data[7];
            $SEM_I = $data[8];
            $SEM_II = $data[9];
            $SEM_III = $data[10];
            $SEM_IV = $data[11];
            $SEM_V = $data[12];
            $SEM_VI = $data[13];
            $SEM_VII = $data[14];
            $SEM_VIII = $data[15];

            // Debugging: Print the data being read
            // echo "Read data: $name, $email, $prn, $cgpa, $gender, $dob, $course, $year, $SEM_I, $SEM_II, $SEM_III, $SEM_IV, $SEM_V, $SEM_VI, $SEM_VII, $SEM_VIII<br>";

            // Check if a row with the same 'prn' exists
            $checkStmt = $conn->prepare("SELECT * FROM students WHERE prn=?");
            $checkStmt->bind_param("s", $prn);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($result->num_rows > 0) {
                // If row exists, update it
                if (!$updateStmt->execute()) {
                    // Debugging: Print SQL error
                    echo "Update failed: (" . $updateStmt->errno . ") " . $updateStmt->error . "<br>";
                }
            } else {
                // If row does not exist, insert it
                if (!$insertStmt->execute()) {
                    // Debugging: Print SQL error
                    echo "Insert failed: (" . $insertStmt->errno . ") " . $insertStmt->error . "<br>";
                }
            }

            // Close the statement
            $checkStmt->close();
        }

        // Close the prepared statements
        $insertStmt->close();
        $updateStmt->close();

        echo "CSV file imported successfully";
    } else {
        echo "Error opening file";
    }

    fclose($handle);
} else {
    echo "Error uploading file";
}

$conn->close();
?>
