<?php

// Create connection
$conn = mysqli_connect("localhost", "root", "", "demopos");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch distinct data from the database
$sql = "SELECT DISTINCT productvariant FROM products WHERE producttype = 'Drink'"; // Replace with your table name and appropriate columns
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
