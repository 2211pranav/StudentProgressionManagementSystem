<?php
// Database connection
include 'conn2.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$searchPRN = "";
$studentData = null;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the PRN from the form
    $searchPRN = $_POST['prn'];

    // Prepare the SQL statement to search for the student's record based on PRN
    $sql = "SELECT * FROM students WHERE prn = '$searchPRN'";

    // Execute the query
    $result = $conn->query($sql);

    // Check if the result was found
    if ($result->num_rows > 0) {
        // Fetch the student's data
        $studentData = $result->fetch_assoc();
    } else {
        echo "No matching records found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Students by PRN</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2, h3 {
            text-align: center;
            color: #4CAF50;
        }
        form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        label, input[type="text"], input[type="submit"] {
            padding: 10px;
            margin: 5px;
            font-size: 16px;
        }
        input[type="text"] {
            flex: 1;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
        canvas {
            display: block;
            margin: 0 auto;
            width: 100% !important;
            max-width: 800px;
            height: 400px !important;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container">
    <h2>Search Students by PRN</h2>

    <form action="" method="post">
        <label for="prn">Enter PRN:</label>
        <input type="text" id="prn" name="prn" value="<?php echo $searchPRN; ?>">
        <input type="submit" value="Search">
    </form>

    <?php if ($studentData): ?>
        <h3>Student Information</h3>
        <table>
            <tr><th>Name</th><td><?php echo $studentData['name']; ?></td></tr>
            <tr><th>Email</th><td><?php echo $studentData['email']; ?></td></tr>
            <tr><th>PRN</th><td><?php echo $studentData['prn']; ?></td></tr>
            <tr><th>CGPA</th><td><?php echo $studentData['cgpa']; ?></td></tr>
            <tr><th>DEPARTMENT</th><td><?php echo $studentData['gender']; ?></td></tr>
            <tr><th>Date of Birth</th><td><?php echo $studentData['dob']; ?></td></tr>
           
            <tr><th>Year</th><td><?php echo $studentData['year']; ?></td></tr>
        </table>

        <h3>Semester Results</h3>
        <canvas id="semResultsChart"></canvas>
        
        <script>
            // Prepare the data for the chart
            const semResults = {
                labels: ['SEM I', 'SEM II', 'SEM III', 'SEM IV', 'SEM V', 'SEM VI', 'SEM VII', 'SEM VIII'],
                datasets: [{
                    label: 'Semester Results',
                    data: [
                        <?php echo $studentData['SEM_I']; ?>,
                        <?php echo $studentData['SEM_II']; ?>,
                        <?php echo $studentData['SEM_III']; ?>,
                        <?php echo $studentData['SEM_IV']; ?>,
                        <?php echo $studentData['SEM_V']; ?>,
                        <?php echo $studentData['SEM_VI']; ?>,
                        <?php echo $studentData['SEM_VII']; ?>,
                        <?php echo $studentData['SEM_VIII']; ?>
                    ],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            // Create the chart
            const ctx = document.getElementById('semResultsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: semResults,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    <?php endif; ?>
</div>

</body>
</html>

<?php
// Close connection
$conn->close();
?>