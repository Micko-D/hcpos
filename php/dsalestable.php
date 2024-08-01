<?php
date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippine Time
// Create connection
$conn = mysqli_connect("localhost","root","","demopos");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$currentDate = date('Y-m-d'); // Format: YYYY-MM-DD

// Fetch data from the database
$sql = "SELECT * FROM orders WHERE orderdate = '$currentDate' GROUP BY orderid"; // Replace with your table name
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

// Return data as JSON response
header("Content-Type: application/json");
echo json_encode($data);
?>
