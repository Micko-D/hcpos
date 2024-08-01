<?php
// Create connection
$conn = mysqli_connect("localhost","root","","demopos");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');

// Fetch order types data for the current month

$salesType = $_POST['salesType'];
$orderTypes = $_POST['categories'];
// $orderTypes = ['Dine-In', 'Take-Away', 'Delivery', 'AR'];

$sql = "SELECT ordertype, COUNT(DISTINCT orderid) as count 
FROM orders 
WHERE ";

if ($salesType === 'Daily') {
    $sql .= "DATE(orderdate) = CURDATE()";
} elseif ($salesType === 'Monthly') {
    $sql .= "MONTH(orderdate) = $currentMonth AND YEAR(orderdate) = $currentYear";
} elseif ($salesType === 'Yearly') {
    $sql .= "YEAR(orderdate) = $currentYear";
}

$sql .= " AND ordertype IN ('" . implode("', '", $orderTypes) . "') GROUP BY ordertype";
$result = $conn->query($sql);

$orderTypesData = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orderTypesData['labels'][] = $row['ordertype'];
        $orderTypesData['datasets'][0]['data'][] = $row['count'];
    }
} else {
    $orderTypesData['labels'] = array();
    $orderTypesData['datasets'][0]['data'] = array();
}

// Set colors for the doughnut chart
$colors = ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'];
$orderTypesData['datasets'][0]['backgroundColor'] = $colors;

// Close the database connection
$conn->close();

if (empty($orderTypesData['labels'])) {
    $orderTypesData['labels'][] = 'No Data';
    $orderTypesData['datasets'][0]['data'][] = 0;
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($orderTypesData);

?>
