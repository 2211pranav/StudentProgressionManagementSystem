<?php
// Start the session
session_start();

// Database connection
include "conn2.php";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$searchProgram = "";
$searchYear = "";
$results = array();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    // Get the program and year from the form
    $searchProgram = $_POST['program'];
    $searchYear = $_POST['year'];

    // Store the search criteria in the session
    $_SESSION['searchProgram'] = $searchProgram;
    $_SESSION['searchYear'] = $searchYear;

    // Prepare the SQL statement to search for matching records based on program and year
    $sql = "SELECT * FROM students WHERE course LIKE '%$searchProgram%' AND year LIKE '%$searchYear%'";

    // Execute the query
    $result = $conn->query($sql);

    // Check if any results were found
    if ($result->num_rows > 0) {
        // Fetch and store the results in an array
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
        // Store results in the session
        $_SESSION['results'] = $results;
    } else {
        // No results found
        echo "<p class='no-results'>No matching records found.</p>";
    }
} elseif (isset($_SESSION['results'])) {
    // Retrieve results from the session
    $results = $_SESSION['results'];
}

// Handle CSV download request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['download'])) {
    // Retrieve results from the session
    if (isset($_SESSION['results'])) {
        $results = $_SESSION['results'];
        $filename = "students.csv";
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        $output = fopen("php://output", "w");
        $header = array("serial no", "Name", "Email", "PRN", "CGPA", "dept", "dob", "Year", "SEM I", "SEM II", "SEM III", "SEM IV", "SEM V", "SEM VI", "SEM VII", "SEM VIII","Program" );
        fputcsv($output, $header);

        $serial_no = 1;
        foreach ($results as $row) {
            fputcsv($output, array_merge(array($serial_no++), $row));
        }
        fclose($output);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Students by Program and Year</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            padding: 20px;
        }
        h2 {
            color: #444;
            text-align: center;
        }
        form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        label {
            margin: 0 10px 0 0;
            font-weight: bold;
        }
        input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #5cb85c;
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        .download-btn {
            text-align: center;
            margin-top: 20px;
        }
        .download-btn input[type="submit"] {
            background-color: #0275d8;
        }
        .download-btn input[type="submit"]:hover {
            background-color: #025aa5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .no-results {
            text-align: center;
            color: #d9534f;
            font-weight: bold;
        }
        .chart-btn {
            text-align: center;
            margin-top: 20px;
        }
        .chart-btn button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #0275d8;
            color: #fff;
            cursor: pointer;
        }
        .chart-btn button:hover {
            background-color: #025aa5;
        }
    </style>
</head>
<body>

<h2>Search Students by Department and Year</h2>

<form action="" method="post">
    <label for="program">Enter Department:</label>
    <input type="text" id="program" name="program" value="<?php echo htmlspecialchars($searchProgram); ?>">
    <label for="year">Enter Year:</label>
    <input type="text" id="year" name="year" value="<?php echo htmlspecialchars($searchYear); ?>">
    <input type="submit" name="search" value="Search">
</form>

<?php if (!empty($results)): ?>
    <div class="download-btn">
        <form action="" method="post">
            <input type="hidden" name="download" value="1">
            <input type="submit" value="Download CSV">
        </form>
    </div>

    <table>
        <tr>
            <th>Serial No</th>
            <th>Name</th>
            <th>Email</th>
            <th>PRN</th>
            <th>CGPA</th>
            <th>Department</th>
            <th>Year</th>
            <th>SEM I</th>
            <th>SEM II</th>
            <th>SEM III</th>
            <th>SEM IV</th>
            <th>SEM V</th>
            <th>SEM VI</th>
            <th>SEM VII</th>
            <th>SEM VIII</th>
        </tr>
        <?php 
        $serial_no = 1;
        foreach ($results as $row): ?>
            <tr>
                <td><?php echo $serial_no++; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['prn']); ?></td>
                <td><?php echo htmlspecialchars($row['cgpa']); ?></td>
                <td><?php echo htmlspecialchars($row['course']); ?></td>
                <td><?php echo htmlspecialchars($row['year']); ?></td>
                <td><?php echo htmlspecialchars($row['SEM_I']); ?></td>
                <td><?php echo htmlspecialchars($row['SEM_II']); ?></td>
                <td><?php echo htmlspecialchars($row['SEM_III']); ?></td>
                <td><?php echo htmlspecialchars($row['SEM_IV']); ?></td>
                <td><?php echo htmlspecialchars($row['SEM_V']); ?></td>
                <td><?php echo htmlspecialchars($row['SEM_VI']); ?></td>
                <td><?php echo htmlspecialchars($row['SEM_VII']); ?></td>
                <td><?php echo htmlspecialchars($row['SEM_VIII']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="chart-btn">
        <form action="piechart.php" method="post">
            <button type="submit">View Pie Chart</button>
        </form>
    </div>

<?php endif; ?>

</body>
</html>

<?php
// Close connection
$conn->close();
?>