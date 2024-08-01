<?php

// Create connection
$conn = mysqli_connect("localhost","root","","demopos");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$prodname = $_POST['prodname'];
// Fetch data from the database

if ($prodname === 'Wings'){
$sql = "SELECT * FROM products WHERE producttype = 'Inventory' AND prodname = 'Chicken Wings'";
}else{
    $sql = "SELECT * FROM products WHERE producttype = 'Inventory' AND prodname = '$prodname'";
}

// Replace with your table name
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
