<?php
// Create connection
$conn = mysqli_connect("localhost","root","","demopos");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT DATE_FORMAT(orderdate, '%M %Y') AS month_year, SUM(CAST(SUBSTRING(totalprice, 5) AS DECIMAL(10, 2))) AS total_sales
          FROM orders
          WHERE orderdate >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
          GROUP BY month_year
          ORDER BY orderdate";
$result = $conn->query($query);

if ($result) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            "month_year" => $row['month_year'],
            "total_sales" => $row['total_sales']
        );
    }

    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(array("error" => "Database query error"));
}

$conn->close();


?>
