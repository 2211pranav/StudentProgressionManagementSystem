<?php
// Database connection
include 'conn2.php';

if ($_FILES["csvFile"]["error"] == 0) {
    $filename = $_FILES["csvFile"]["tmp_name"];
    $nm=$_FILES["csvFile"]["name"];
    $size=$_FILES["csvFile"]["size"];
    $p1=fopen("$filename","r");
    $p2=fopen("files/$nm","w");
    $data=fread($p1,$size);

    fclose($p1);
    fwrite($p2,$data);
    fclose($p2);
    // Read the file
    if (($handle = fopen($filename, "r")) !== false) {
        // Skip the first row if it contains headers
        fgetcsv($handle);

        // Prepare the SQL statement to insert data
        //$stmt = $conn->prepare("INSERT INTO students (name, email, prn, cgpa, gender, dob, course, year) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind parameters
        //$stmt->bind_param("ssssssss", $name, $email, $prn, $cgpa, $gender, $dob, $course, $year);

        // Read and insert data row by row
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $name = $data[0];
            $email = $data[1];
            $prn = $data[2];
            $cgpa = $data[3];
            $gender = $data[4];
            $dob = $data[5];
            $course = $data[6];
          //  $year = $data[7];
            print_r($data);
          //  $stmt->execute();
            
        }

        // Close the prepared statement
        //$stmt->close();

        echo "<script>alert('CSV file imported successfully');window.location='home.php'</script>";
    } else {
        echo "Error opening file";
    }

    fclose($handle);
} else {
    echo "Error uploading file";
}

$conn->close();
?>
