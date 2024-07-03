<?php 
session_start();
include("menus.php");
include("conn.php"); // Include your database connection file

$dip = htmlspecialchars($_GET["name"]);
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
            <h2><?php echo $dip . " Engineering Department"; ?></h2>
        </div>

        <div class="table-container">
            <form method="post" action="save_changes1.php">
                <input type="hidden" name="dip" value="<?php echo $dip; ?>">
                <div class="table-wrapper">
                    <table border="1" cellpadding="20px" cellspacing="5px" id="dataTable">
                        <thead>
                            <tr>
                                <th rowspan="2">AY</th>
                                <th colspan="2">F.Y. Admitted</th>
                                <th colspan="2">S.Y. Admitted</th>
                                <th colspan="2">T.Y. Admitted</th>
                                <th colspan="2">T.Y. Passed</th>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch data from the database
                            $query = $conn->prepare("SELECT * FROM diplomadata WHERE diploma_name = ?");
                            $query->bind_param("s", $dip);
                            $query->execute();
                            $result = $query->get_result();
                            $data_points = $result->fetch_all(MYSQLI_ASSOC);

                            // Output rows with input fields
                            for ($i = 0; $i < count($data_points); $i++) {
                                echo "<tr>";
                                echo "<td><input type='text' name='data[$i][0]' value='" . htmlspecialchars($data_points[$i]['ay']) . "'></td>"; // AY column as input field

                                // Input fields for admitted and passed students
                                for ($j = 1; $j <= 8; $j++) { // Only iterate through columns 1 to 8 (Admitted and Passed columns)
                                    $field = [
                                        1 => 'fy_admitted_regular',
                                        2 => 'fy_admitted_dsy',
                                        3 => 'sy_admitted_regular',
                                        4 => 'sy_admitted_dsy',
                                        5 => 'ty_admitted_regular',
                                        6 => 'ty_admitted_dsy',
                                        7 => 'ty_passed_regular',
                                        8 => 'ty_passed_dsy'
                                    ][$j];
                                    $value = htmlspecialchars($data_points[$i][$field]);
                                    echo "<td><input type='text' name='data[$i][$j]' value='$value'></td>";
                                }

                                // Calculate progression percentages
                                $fy_admitted_regular = $data_points[$i]['fy_admitted_regular'] ?? 0;
                                $ty_passed_regular = $data_points[$i]['ty_passed_regular'] ?? 0;
                                $sy_admitted_dsy = $data_points[$i]['sy_admitted_dsy'] ?? 0;
                                $ty_passed_dsy = $data_points[$i]['ty_passed_dsy'] ?? 0;

                                $progression_regular = $fy_admitted_regular ? ($ty_passed_regular / $fy_admitted_regular) * 100 : 0;
                                $progression_dsy = $sy_admitted_dsy ? ($ty_passed_dsy / $sy_admitted_dsy) * 100 : 0;

                                // Print progression percentages directly
                                echo "<td>" . number_format($progression_regular, 2) . "%</td>";
                                echo "<td>" . number_format($progression_dsy, 2) . "%</td>";

                                // Adding the "Update" button and "View Graph" link
                                echo "<td><button type='submit' name='update_row' value='$i'>Update</button></td>";
                                echo "<td><a href='progress1.php?ay=" . urlencode($data_points[$i]['ay']) . "&dip=" . urlencode($dip) . "'>View Graph</a></td>";
                                echo "</tr>";
                            }

                            // Adding additional rows for new data entry
                            $numRows = 10; // Number of empty rows you want to add
                            for ($i = count($data_points); $i < count($data_points) + $numRows; $i++) {
                                echo "<tr>";
                                echo "<td><input type='text' name='data[$i][0]' value=''></td>"; // AY column as input field
                                for ($j = 1; $j <= 8; $j++) { // Only iterate through columns 1 to 8 (Admitted and Passed columns)
                                    echo "<td><input type='text' name='data[$i][$j]' value=''></td>";
                                }
                                echo "<td></td><td></td>"; // Empty cells for progression percentages
                                echo "<td><button type='submit' name='update_row' value='$i'>Update</button></td>";
                                echo "<td><a href='progress1.php?ay='>View Graph</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <button type="button" onclick="addRow()">Add Year</button>
                </div>
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
function addRow() {
    var table = document.getElementById("dataTable").getElementsByTagName('tbody')[0];
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    
    // Add AY input field
    var cell = row.insertCell(0);
    var element = document.createElement("input");
    element.type = "text";
    element.name = `data[${rowCount}][0]`;
    cell.appendChild(element);
    
    // Add input fields for admitted and passed students
    for (var i = 1; i <= 8; i++) {
        cell = row.insertCell(i);
        element = document.createElement("input");
        element.type = "text";
        element.name = `data[${rowCount}][${i}]`;
        cell.appendChild(element);
    }

    // Add empty cells for progression percentages
    row.insertCell(9);
    row.insertCell(10);
    
    // Add "Update" button
    cell = row.insertCell(11);
    var updateButton = document.createElement("button");
    updateButton.type = "submit";
    updateButton.name = "update_row";
    updateButton.value = rowCount;
    updateButton.textContent = "Update";
    cell.appendChild(updateButton);

    // Add "View Graph" link
    cell = row.insertCell(12);
    var viewLink = document.createElement("a");
    viewLink.href = "progress1.php?ay="; // Add logic to append the correct AY value
    viewLink.textContent = "View Graph";
    cell.appendChild(viewLink);
}
</script>

<?php
include("footer.php");
?>
