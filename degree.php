<?php 
session_start();
include("menus.php");
include("conn.php"); // Include your database connection file

$deg = htmlspecialchars($_GET["name"]);
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
            <h2><?php echo $deg . " Engineering Department"; ?></h2>
        </div>

        <div class="table-container">
            <form method="post" action="save_changes.php" id="dataForm">
                <input type="hidden" name="deg" value="<?php echo $deg; ?>">
                <div class="table-wrapper">
                    <table border="1" cellpadding="20px" cellspacing="5px" id="dataTable">
                        <thead>
                            <tr>
                                <th rowspan="2">AY</th>
                                <th colspan="2">F.Y. Admitted</th>
                                <th colspan="2">S.Y. Admitted</th>
                                <th colspan="2">T.Y. Admitted</th>
                                <th colspan="2">B.Tech. Admitted</th>
                                <th colspan="2">B.Tech. Passed</th>
                                <th colspan="2">% Progression</th>
                                <th rowspan="2">Update</th>
                                <th rowspan="2">View Graph</th>
                            </tr>
                            <tr>
                                <th>Regular</th><th>DSY</th>
                                <th>Regular</th><th>DSY</th>
                                <th>Regular</th><th>DSY</th>
                                <th>Regular</th><th>DSY</th>
                                <th>Regular</th><th>DSY</th>
                                <th>Regular</th><th>DSY</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch data from the database
                            $query = $conn->prepare("SELECT * FROM degreedata WHERE degree_name = ?");
                            $query->bind_param("s", $deg);
                            $query->execute();
                            $result = $query->get_result();
                            $data_points = $result->fetch_all(MYSQLI_ASSOC);

                            // Output rows with input fields
                            for ($i = 0; $i < count($data_points); $i++) {
                                echo "<tr>";
                                echo "<td><input type='text' name='data[$i][0]' value='".htmlspecialchars($data_points[$i]['ay'])."'></td>"; // AY column as input field

                                // Input fields for admitted and passed students
                                for ($j = 1; $j <= 10; $j++) { // Only iterate through columns 1 to 10 (Admitted and Passed columns)
                                    $field = [
                                        1 => 'fy_admitted_regular',
                                        2 => 'fy_admitted_dsy',
                                        3 => 'sy_admitted_regular',
                                        4 => 'sy_admitted_dsy',
                                        5 => 'ty_admitted_regular',
                                        6 => 'ty_admitted_dsy',
                                        7 => 'bt_admitted_regular',
                                        8 => 'bt_admitted_dsy',
                                        9 => 'bt_passed_regular',
                                        10 => 'bt_passed_dsy'
                                    ][$j];
                                    $value = htmlspecialchars($data_points[$i][$field]);
                                    echo "<td><input type='text' name='data[$i][$j]' value='$value'></td>";
                                }

                                // Calculate progression percentages
                                $fy_admitted_regular = $data_points[$i]['fy_admitted_regular'] ?? 0;
                                $bt_passed_regular = $data_points[$i]['bt_passed_regular'] ?? 0;
                                $sy_admitted_dsy = $data_points[$i]['sy_admitted_dsy'] ?? 0;
                                $bt_passed_dsy = $data_points[$i]['bt_passed_dsy'] ?? 0;

                                $progression_regular = $fy_admitted_regular ? ($bt_passed_regular / $fy_admitted_regular) * 100 : 0;
                                $progression_dsy = $sy_admitted_dsy ? ($bt_passed_dsy / $sy_admitted_dsy) * 100 : 0;

                                // Print progression percentages directly
                                echo "<td>".number_format($progression_regular, 2)."%</td>";
                                echo "<td>".number_format($progression_dsy, 2)."%</td>";

                                // Adding the "Update" button and "View Graph" link
                                echo "<td><button type='submit' name='update_row' value='$i'>Update</button></td>";
                                echo "<td><a href='progress.php?ay=". urlencode($data_points[$i]['ay']) ."&deg=". urlencode($deg) ."'>View Graph</a></td>";
                                echo "</tr>";
                            }

                            // Adding additional rows for new data entry
                            $numRows = 10; // Number of empty rows you want to add
                            for ($i = count($data_points); $i < count($data_points) + $numRows; $i++) {
                                echo "<tr>";
                                echo "<td><input type='text' name='data[$i][0]' value=''></td>"; // AY column as input field
                                for ($j = 1; $j <= 10; $j++) { // Only iterate through columns 1 to 10 (Admitted and Passed columns)
                                    echo "<td><input type='text' name='data[$i][$j]' value=''></td>";
                                }
                                echo "<td></td><td></td>"; // Empty cells for progression percentages
                                echo "<td><button type='submit' name='update_row' value='$i'>Update</button></td>";
                                echo "<td><a href='progress.php?ay='>View Graph</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- Add Year button -->
                <button type="button" id="addYearBtn">Add Year</button>
            </form>
        </div>
    </main>
</div>
<style>
.home-section {
    width: 100%;
    background-color: #fff;
}

.main-container {
    width: 100%;
    padding-left: 20px;
}

.table-container {
    width: 100%;
    overflow-x: auto; /* Enables horizontal scrolling */
    background-color: #fff;
    padding-bottom: 20px; /* For better UX */
}

.table-wrapper {
    width: 100%;
    overflow-x: auto;
    max-height: 600px; /* Limit the height and make it scrollable */
}

table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    background-color: #fff;
}

table th, table td {
    padding: 10px;
    text-align: left;
    background-color: #fff;
    position: relative;
}

table thead th {
    background-color: #f2f2f2;
    position: sticky;
    top: 0;
    z-index: 1;
}

.main-title h2 {
    text-align: left;
    margin-left: 20px;
}

input[type="text"] {
    width: 100%;
    box-sizing: border-box;
}

button {
    margin: 20px 0;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}
</style>
<script>
// JavaScript function to add a new row
document.getElementById('addYearBtn').addEventListener('click', function() {
    var table = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
    var newRow = table.insertRow();
    var numRows = table.rows.length;
    var rowIndex = numRows - 1;

    // Insert cells and input fields for the new row
    var cell = newRow.insertCell(0);
    cell.innerHTML = "<input type='text' name='data[" + rowIndex + "][0]' value=''>";

    for (var i = 1; i <= 10; i++) {
        cell = newRow.insertCell(i);
        cell.innerHTML = "<input type='text' name='data[" + rowIndex + "][" + i + "]' value=''>";
    }

    cell = newRow.insertCell(11);
    cell.innerHTML = ""; // Empty cell for progression percentage Regular

    cell = newRow.insertCell(12);
    cell.innerHTML = ""; // Empty cell for progression percentage DSY

    cell = newRow.insertCell(13);
    cell.innerHTML = "<button type='submit' name='update_row' value='" + rowIndex + "'>Update</button>";

    cell = newRow.insertCell(14);
    cell.innerHTML = "<a href='progress.php?ay='>View Graph</a>";
});
</script>
<?php include("footer.php"); ?>
