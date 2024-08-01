<?php

// Create connection
$conn = mysqli_connect("localhost","root","","demopos");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$sql = "SELECT rfid, ordertype, MAX(totalprice) AS totalprice, MAX(orderstatus) AS orderstatus, orderdate, ordertime
FROM (
    SELECT rfid, ordertype, totalprice, orderstatus, orderdate, ordertime
    FROM orders
    WHERE orderstatus IN ('Dine-In', 'Take-Out')
    GROUP BY rfid, orderdate

    UNION

    SELECT rfid, ordertype, totalprice, orderstatus, orderdate, ordertime
    FROM onlineorder
    WHERE orderstatus IN ('Done', 'Cancelled')
    GROUP BY rfid, orderdate, ordertime
) AS combined_data
GROUP BY rfid, orderdate, ordertime;"; // Replace with your table name
$result = $conn->query($sql);

$data = array();

if(!$result){
    die("Query Failed: ". $conn->error);
}

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
