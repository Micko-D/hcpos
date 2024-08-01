<?php
// Create connection
$conn = mysqli_connect("localhost", "root", "", "demopos");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');

$salesType = $_POST['salesType'];
// Fetch monthly average sales data

// $sql = "SELECT CONCAT(MONTH(orderdate), '-', YEAR(orderdate)) AS month_year,
        //        AVG(CAST(SUBSTRING(totalprice, 5) AS DECIMAL(10, 2))) AS average_sales 
        // FROM orders 
        // WHERE ";
        
        
        if ($salesType === 'Daily') {
            $sql = "SELECT DATE(orderdate) AS date,
                   AVG(DISTINCT CAST(SUBSTRING(totalprice, 5) AS DECIMAL(10, 2))) AS average_sales 
            FROM orders 
            WHERE DATE(orderdate) = CURDATE()";
        } elseif ($salesType === 'Monthly') {
            $sql = "SELECT CONCAT(MONTH(orderdate), '-', YEAR(orderdate)) AS month_year,
                   AVG(DISTINCT CAST(SUBSTRING(totalprice, 5) AS DECIMAL(10, 2))) AS average_sales 
            FROM orders 
            WHERE YEAR(orderdate) = $currentYear 
            GROUP BY YEAR(orderdate), MONTH(orderdate)";
        } elseif ($salesType === 'Yearly') {
            $sql = "SELECT YEAR(orderdate) AS year,
                   AVG(DISTINCT CAST(SUBSTRING(totalprice, 5) AS DECIMAL(10, 2))) AS average_sales 
            FROM orders 
            GROUP BY YEAR(orderdate)";
        }
        
        
// $sql .= " GROUP BY YEAR(orderdate), MONTH(orderdate)";
$result = $conn->query($sql);

$averageSalesData = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $averageSalesData[] = $row;
    }
}

// Close the database connection
$conn->close();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($averageSalesData);
?>
