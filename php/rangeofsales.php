<?php
date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippine Time
// Create connection
$conn = mysqli_connect("localhost", "root", "", "demopos");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$startDate = $_POST['startDate']; // Get the start date from the AJAX request
$endDate = $_POST['endDate'];     // Get the end date from the AJAX request

$dateControl = $_POST['dateControlRange'];

$target = $_POST['target'];
// $dateControl = 'Monthly';
// $startDate = "2023-12-10"; // Get the start date from the AJAX request
// $endDate = "2023-12-30";     // Get the end date from the AJAX request
// $target = 'Food';

// Debugging: Log received dates
error_log("Received startDate: $startDate");
error_log("Received endDate: $endDate");

switch ($dateControl) {
    case 'Daily':
        $sql = "(
            SELECT o.rfid, o.productid, p.prodname, p.producttype, p.productvariant, o.subtotal, DATE_FORMAT(o.orderdate, '%M %e, %Y') AS orderdate
            FROM orders o
            JOIN products p ON o.productid = p.prodid
            WHERE p.producttype = '$target' AND  o.orderdate BETWEEN '$startDate' AND '$endDate'
        )
        UNION
        (
            SELECT oo.rfid, oo.productid, p.prodname, p.producttype, p.productvariant, oo.subtotal, DATE_FORMAT(oo.orderdate, '%M %e, %Y') AS orderdate
            FROM onlineorder oo
            JOIN products p ON oo.productid = p.prodid
            WHERE p.producttype = '$target' AND oo.orderdate BETWEEN '$startDate' AND '$endDate'
        )
        ORDER BY rfid ASC";
        
        break;

    case 'Weekly':
        $sql = "SELECT
        combined_data.productid,
        products.prodname,
        products.productprice,
        products.producttype,
        products.productvariant,
        COALESCE(SUM(combined_data.quantity), 0) AS total_quantity,
        COALESCE(SUM(combined_data.quantity * products.productprice), 0) AS total_price,
        CONCAT(
            DATE_FORMAT(MIN(DATE_SUB(combined_data.orderdate, INTERVAL WEEKDAY(combined_data.orderdate) DAY)), '%M %d, %Y'),
            ' to ',
            DATE_FORMAT(MAX(DATE_ADD(combined_data.orderdate, INTERVAL 6 - WEEKDAY(combined_data.orderdate) DAY)), '%M %d, %Y')
        ) AS orderdate
    FROM (
        SELECT
            productid,
            quantity,
            orderdate
        FROM
            orders
        WHERE
            orderdate BETWEEN '$startDate' AND '$endDate'
        UNION ALL
        SELECT
            productid,
            quantity,
            orderdate
        FROM
            onlineorder
        WHERE
            orderdate BETWEEN '$startDate' AND '$endDate'
    ) AS combined_data
    JOIN
        products ON products.prodid = combined_data.productid
    WHERE products.producttype = '$target'
    GROUP BY
        combined_data.productid, products.prodname, products.productvariant, products.productprice, YEAR(combined_data.orderdate), WEEK(combined_data.orderdate)
    ORDER BY combined_data.orderdate;
    
    
    ";
        break;

    case 'Monthly':
        $sql = "
SELECT
    combined_data.productid,
    products.prodname,
    products.productprice,
    products.producttype,
    products.productvariant,
    COALESCE(SUM(combined_data.quantity), 0) AS total_quantity,
    COALESCE(SUM(combined_data.quantity * products.productprice), 0) AS total_price,
    DATE_FORMAT(combined_data.orderdate, '%M %Y') AS orderdate
FROM (
    SELECT
        productid,
        quantity,
        orderdate
    FROM
        orders
    WHERE orderdate BETWEEN '$startDate' AND '$endDate'
    UNION ALL
    SELECT
        productid,
        quantity,
        orderdate
    FROM
        onlineorder
    WHERE orderdate BETWEEN '$startDate' AND '$endDate'
) AS combined_data
JOIN
    products ON products.prodid = combined_data.productid
WHERE products.producttype = '$target'
GROUP BY
    combined_data.productid, products.prodname, products.productvariant, products.productprice, YEAR(combined_data.orderdate), MONTH(combined_data.orderdate)
ORDER BY combined_data.orderdate;
";

        break;

    default:
        // Handle other cases if needed
        break;
}


$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error); // Display the SQL error message
}

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
