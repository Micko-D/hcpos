<?php

// Create connection
$conn = mysqli_connect("localhost","root","","demopos");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $orderid = $_GET['orderid'];
$rfid = $_GET['rfid'];
$ordertype = $_GET['ordertype'];
$orderdate = $_GET['orderdate'];
$ordertime = $_GET['ordertime'];

// Fetch data from the database
$sql = "SELECT * FROM orders WHERE rfid='$rfid' AND ordertype='$ordertype' AND orderdate='$orderdate' AND ordertime='$ordertime'"; // Replace with your table name
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
