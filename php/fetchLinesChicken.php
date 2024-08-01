<?php
// Create connection
$conn = mysqli_connect("localhost", "root", "", "demopos");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT CONCAT(YEAR(o.orderdate), '-', MONTH(o.orderdate)) AS order_month_year,
o.productid, p.prodname, SUM(o.quantity) AS total_quantity,
COALESCE(SUM(addon_counts.total_addons), 0) AS total_addons
FROM (
SELECT o.productid, o.quantity, o.orderdate
FROM orders o
UNION ALL
SELECT o.productid, o.quantity, o.orderdate
FROM onlineorder o
WHERE o.orderstatus = 'Done'
) AS o
JOIN products p ON o.productid = p.prodid
LEFT JOIN (
SELECT o.productid, COUNT(a.addonname) AS total_addons, YEAR(o.orderdate) AS addon_year, MONTH(o.orderdate) AS addon_month
FROM orders o
JOIN addonorder a ON o.orderid = a.orderid
GROUP BY o.productid, addon_year, addon_month

UNION ALL

SELECT o.productid, COUNT(a.addonname) AS total_addons, YEAR(o.orderdate) AS addon_year, MONTH(o.orderdate) AS addon_month
FROM onlineorder o
JOIN onlineaddon a ON o.orderid = a.orderid 
WHERE o.orderstatus = 'Done'
GROUP BY o.productid, addon_year, addon_month
) AS addon_counts ON o.productid = addon_counts.productid
AND YEAR(o.orderdate) = addon_counts.addon_year
AND MONTH(o.orderdate) = addon_counts.addon_month
WHERE p.producttype = 'Food' 
AND p.prodname LIKE '%Wing%'
GROUP BY order_month_year, o.productid
ORDER BY order_month_year, o.productid;
";



$result = mysqli_query($conn, $query);

if ($result) {
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            "prodid" => $row['productid'],
            "product_name" => $row['prodname'],
            "order_month_year" => $row['order_month_year'],
            "total_quantity" => $row['total_quantity']
        );
    }

    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(array("error" => "Database query error: " . mysqli_error($conn)));
}

mysqli_close($conn);
?>
