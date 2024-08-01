<?php
// Create connection
$conn = mysqli_connect("localhost","root","","demopos");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$currentMonth = date('m');
$currentYear = date('Y');

$salesType = $_POST['salesType'];
$categories = $_POST['categories'];

// $salesType = 'Monthly';
// $categories = ['Dine-In', 'Take-Out', 'Delivery', 'AR'];

// Fetch product types data for the current month and year from both orders and onlineorder
$sql = "
    SELECT producttype, COUNT(*) as count 
    FROM (
        SELECT o.productid, o.orderdate, o.orderstatus, p.producttype
        FROM orders o 
        JOIN products p ON o.productid = p.prodid
        WHERE ";

if ($salesType === 'Daily') {
    $sql .= "DATE(o.orderdate) = CURDATE()";
} elseif ($salesType === 'Monthly') {
    $sql .= "MONTH(o.orderdate) = $currentMonth AND YEAR(o.orderdate) = $currentYear";
} elseif ($salesType === 'Yearly') {
    $sql .= "YEAR(o.orderdate) = $currentYear";
}

$sql .= "  AND p.prodid != '100001'
        
        UNION ALL

        SELECT oo.productid, oo.orderdate, NULL AS orderstatus, p.producttype
        FROM onlineorder oo
        JOIN products p ON oo.productid = p.prodid
        WHERE ";

if ($salesType === 'Daily') {
    $sql .= "DATE(oo.orderdate) = CURDATE()";
} elseif ($salesType === 'Monthly') {
    $sql .= "MONTH(oo.orderdate) = $currentMonth AND YEAR(oo.orderdate) = $currentYear";
} elseif ($salesType === 'Yearly') {
    $sql .= "YEAR(oo.orderdate) = $currentYear";
}

$sql .= " AND p.prodid != '100001'
    ) AS combined_data
    GROUP BY producttype";


        
        $result = $conn->query($sql);

        // Check for query execution errors
if (!$result) {
    die("Query failed: " . $conn->error);
}

        $productTypesData = array();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productTypesData['labels'][] = $row['producttype'];
                $productTypesData['datasets'][0]['data'][] = $row['count'];
            }
        } else {
            $productTypesData['labels'] = array();
            $productTypesData['datasets'][0]['data'] = array();
        }
        
        // Set colors for the pie chart
        $colors = ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'];
        $productTypesData['datasets'][0]['backgroundColor'] = $colors;
        
        // Close the database connection
        $conn->close();
        
        // Return the data as JSON
        header('Content-Type: application/json');
        echo json_encode($productTypesData);

?>
