<?php
session_start();
include("menus.php");
include("conn.php"); // Include your database connection file

$ay = htmlspecialchars($_GET["ay"]);
$dip = htmlspecialchars($_GET["dip"]);

$ayear = explode("-", $ay)[0];
$years = [];
for ($i = 0; $i <= 3; $i++) {
    $years[] = $ayear + $i;
}

// Fetch data from the database
$query = $conn->prepare("SELECT * FROM diplomadata WHERE diploma_name = ? AND ay = ?");
$query->bind_param("ss", $dip, $ay);
$query->execute();
$result = $query->get_result();
$selected_data = $result->fetch_assoc();

// Determine the intake capacity based on the department
$intake_capacity = ($dip === "Computer") ? 90 : 60;

?>

<div class="home-section">
    <div class="home-content">
        <i class="fas fa-bars"></i>
        <span class="text">Student Progression Management System</span>
    </div>
    <br clear="all"><br>
    <main class="main-container">
        <!-- Main Title -->
        <div class="main-title">
            <h2>
                Progress of <?php echo htmlspecialchars($dip) . " Engineering"; ?> for Admitted Year <?php echo htmlspecialchars($ayear); ?>
            </h2>
        </div>
        <hr>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f7f7f7;
                margin: 0;
                padding: 0;
            }
            h2 {
                text-align: center;
                color: #333;
                margin-top: 20px;
            }
            .chart-container {
                width: 70%; /* Adjust width as needed */
                margin: 0 auto;
                text-align: center;
            }
            canvas {
                width: 100%; /* Ensure canvas fills its container */
                height: 400px; /* Set desired height */
                margin: 0 auto;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
        </style>
        <div class="chart-container">
            <!-- Canvas element for Chart.js -->
            <canvas id="myChart"></canvas>
        </div>
        <script>
            var labels = [
                "<?php echo $ayear; ?> F.Y.",
                "<?php echo $ayear + 1; ?> S.Y.",
                "<?php echo $ayear + 2; ?> T.Y.",
                "<?php echo $ayear + 3; ?> Passed"
            ];

            var dataRegular = [];
            var dataDSY = [];

            <?php if (!empty($selected_data)): ?>
                var selectedData = <?php echo json_encode($selected_data); ?>;

                // Calculate progress percentages
                dataRegular.push((selectedData.fy_admitted_regular / <?php echo $intake_capacity; ?>) * 100);
                dataRegular.push((selectedData.sy_admitted_regular / <?php echo $intake_capacity; ?>) * 100);
                dataRegular.push((selectedData.ty_admitted_regular / <?php echo $intake_capacity; ?>) * 100);
                dataRegular.push((selectedData.ty_passed_regular / <?php echo $intake_capacity; ?>) * 100);
              
                dataDSY.push((selectedData.fy_admitted_dsy / <?php echo $intake_capacity; ?>) * 100);
                dataDSY.push((selectedData.sy_admitted_dsy / <?php echo $intake_capacity; ?>) * 100);
                dataDSY.push((selectedData.ty_admitted_dsy / <?php echo $intake_capacity; ?>) * 100);
                dataDSY.push((selectedData.ty_passed_dsy / <?php echo $intake_capacity; ?>) * 100);
                
            <?php endif; ?>

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels, // Year and class labels
                    datasets: [
                        {
                            label: 'Regular',
                            data: dataRegular,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)', // Blue color with transparency
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'DSY',
                            data: dataDSY,
                            backgroundColor: 'rgba(255, 99, 132, 0.5)', // Red color with transparency
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100 // Set the maximum value to 100 for percentage
                        }
                    }
                }
            });
        </script>
    </main>
</div>

<?php
include("footer.php");
?>
