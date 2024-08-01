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
// $salesType = 'Daily';
        
        
        if ($salesType === 'Daily') {
            $sql = "SELECT 
            orderdate,
            SUM(CAST(SUBSTRING(totalprice, 5) AS DECIMAL(10, 2))) AS daily_sales
        FROM (
            SELECT DISTINCT 
                orderid,
                DATE(orderdate) AS orderdate,
                totalprice
            FROM orders
            WHERE DATE(orderdate) = CURDATE()
        ) AS subquery
        GROUP BY orderid, orderdate;
        ";

        } elseif ($salesType === 'Weekly') {
            // Calculate the start and end dates for the current week
            $startDate = date('Y-m-d', strtotime('last Sunday'));
            $endDate = date('Y-m-d', strtotime('next Saturday'));

            $sql = "SELECT order_date, SUM(total_price_sum) AS average_sales
            FROM (
                SELECT orderid,
                       DATE(orderdate) AS order_date,
                       SUM(CAST(SUBSTRING(totalprice, 5) AS DECIMAL(10, 2))) AS total_price_sum
                FROM (
                    SELECT DISTINCT orderid, orderdate, totalprice
                    FROM orders
                    WHERE orderdate BETWEEN '$startDate' AND '$endDate'
                ) AS subquery
                GROUP BY orderid, order_date
            ) AS weekly_data
            GROUP BY order_date";
            }elseif ($salesType === 'Monthly') {

                $startOfMonth = date('Y-m-01');
                $endOfMonth = date('Y-m-t');

                $sql = "SELECT order_date, SUM(total_price_sum) AS average_sales
                FROM (
                    SELECT orderid,
                           DATE(orderdate) AS order_date,
                           SUM(CAST(SUBSTRING(totalprice, 5) AS DECIMAL(10, 2))) AS total_price_sum
                    FROM (
                        SELECT DISTINCT orderid, orderdate, totalprice
                        FROM orders
                        WHERE orderdate BETWEEN '$startOfMonth' AND '$endOfMonth'
                    ) AS subquery
                    GROUP BY orderid, order_date
                ) AS monthly_data
                GROUP BY order_date";

        } elseif ($salesType === 'Yearly') {
            $sql = "SELECT YEAR(order_date) AS year, SUM(total_price_sum) AS average_sales
            FROM (
                SELECT orderid,
                       DATE(orderdate) AS order_date,
                       SUM(CAST(SUBSTRING(totalprice, 5) AS DECIMAL(10, 2))) AS total_price_sum
                FROM (
                    SELECT DISTINCT orderid, orderdate, totalprice
                    FROM orders
                ) AS subquery
                GROUP BY orderid, order_date
            ) AS yearly_data
            GROUP BY YEAR(order_date)";
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
