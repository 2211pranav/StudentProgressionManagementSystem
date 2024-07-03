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

// Retrieve search criteria from session
$searchProgram = isset($_SESSION['searchProgram']) ? $_SESSION['searchProgram'] : '';
$searchYear = isset($_SESSION['searchYear']) ? $_SESSION['searchYear'] : '';

// Fetch CGPA data from the database
$stmt = $conn->prepare("SELECT cgpa FROM students WHERE course LIKE ? AND year LIKE ?");
$searchProgram = "%$searchProgram%";
$searchYear = "%$searchYear%";
$stmt->bind_param("ss", $searchProgram, $searchYear);
$stmt->execute();
$result = $stmt->get_result();

// Initialize variables to count pass, average, distinction, and fail
$passCount = 0;
$averageCount = 0;
$distinctionCount = 0;
$failCount = 0;
$TotalCount = 0;

// Process fetched data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cgpa = $row['cgpa'];
        // Categorize CGPA into pass, average, distinction, and fail
        if ($cgpa < 5) {
            $failCount++;
        } elseif ($cgpa < 5.5 && $cgpa >= 5) {
            $passCount++;
        } elseif ($cgpa >= 5.5 && $cgpa <= 6.9) {
            $averageCount++;
        } elseif ($cgpa >= 7) {
            $distinctionCount++;
        }
    }
}
$TotalCount = $passCount + $averageCount + $distinctionCount + $failCount;

// Close statement and connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CGPA Classification Pie Chart</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
            font-size: 2em;
        }
        #chart-container {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 60%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-size: 1.1em;
        }
        td {
            background-color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<h2>CGPA Classification Pie Chart</h2>

<!-- Container for Chart.js -->
<div id="chart-container">
    <canvas id="myChart"></canvas>
</div>

<!-- Table to display criteria counts -->
<table>
    <tr>
        <th>Criteria</th>
        <th>Count</th>
    </tr>
    <tr>
        <td>Pass</td>
        <td><?php echo $passCount; ?></td>
    </tr>
    <tr>
        <td>Average</td>
        <td><?php echo $averageCount; ?></td>
    </tr>
    <tr>
        <td>Distinction</td>
        <td><?php echo $distinctionCount; ?></td>
    </tr>
    <tr>
        <td>Fail</td>
        <td><?php echo $failCount; ?></td>
    </tr>
    <tr>
        <th>Total Count</th>
        <th><?php echo $TotalCount; ?></th>
    </tr>
</table>

<script>
    // Get pass, average, distinction, and fail counts from PHP and convert to JavaScript array
    var passCount = <?php echo $passCount; ?>;
    var averageCount = <?php echo $averageCount; ?>;
    var distinctionCount = <?php echo $distinctionCount; ?>;
    var failCount = <?php echo $failCount; ?>;

    // Create a pie chart using Chart.js
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Pass', 'Average', 'Distinction', 'Fail'],
            datasets: [{
                data: [passCount, averageCount, distinctionCount, failCount],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.7)', // green for pass
                    'rgba(54, 162, 235, 0.7)', // Blue for average
                    'rgba(255, 206, 86, 0.7)', // Yellow for distinction
                    'rgba(255, 99, 132, 0.7)' // red for fail
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)', // green for pass
                    'rgba(54, 162, 235, 1)', // Blue for average
                    'rgba(255, 206, 86, 1)', // Yellow for distinction
                    'rgba(255, 99, 132, 1)' // red for fail
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 16
                        }
                    }
                }
            },
            animation: {
                animateRotate: true, // Rotate animation on hover
                animateScale: true // Scale animation on hover
            }
        }
    });

    // Adjust canvas size on window resize
    window.addEventListener('resize', function() {
        var chartContainer = document.getElementById('chart-container');
        var canvas = document.getElementById('myChart');
        canvas.width = chartContainer.offsetWidth;
        canvas.height = chartContainer.offsetHeight;
        myChart.resize();
    });
</script>

</body>
</html>
