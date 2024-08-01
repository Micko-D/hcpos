<?php
// Create connection
$conn = mysqli_connect("localhost", "root", "", "demopos");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Fetch data from the database
$query = "
SELECT p.prodid, p.producttype, SUM(o.quantity) as total_quantity
FROM orders o
JOIN products p ON o.productid = p.prodid
WHERE p.producttype = 'Drink' AND p.prodid != '100001' AND WEEK(o.orderdate) = WEEK(NOW())
GROUP BY p.prodid
UNION
SELECT p.prodid, p.producttype, SUM(oo.quantity) as total_quantity
FROM onlineorder oo
JOIN products p ON oo.productid = p.prodid
WHERE p.producttype = 'Drink' AND p.prodid != '100001' AND WEEK(oo.orderdate) = WEEK(NOW())
GROUP BY p.prodid
";



$result = $conn->query($query);

// Check for query execution errors
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Create an associative array to store the labels and datasets
$data = [
    'labels' => [],
    'datasets' => [
        [
            'data' => [],
            'backgroundColor' => [], // Add your desired colors here
        ],
    ],
];

function getRandomColor() {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}
// Fetch product names based on productid
while ($row = $result->fetch_assoc()) {
    $productid = $row['prodid'];
    $totalQuantity = $row['total_quantity'];

    // Fetch product name based on productid
    $productNameQuery = "SELECT prodname FROM products WHERE prodid = $productid";
    $productNameResult = $conn->query($productNameQuery);

    if ($productNameResult->num_rows > 0) {
        $productNameRow = $productNameResult->fetch_assoc();
        $productName = $productNameRow['prodname'];

        // Append data to the associative array
        $data['labels'][] = $productName;
        $data['datasets'][0]['data'][] = $totalQuantity;
        $data['datasets'][0]['backgroundColor'][] = getRandomColor(); // Set a default color, or customize as needed
    }

    
}

$data['labels'][] = '';
$data['datasets'][0]['data'][] = 0;

// Close the database connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
