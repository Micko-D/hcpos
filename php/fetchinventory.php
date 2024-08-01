<?php

// Create connection
$conn = mysqli_connect("localhost","root","","demopos");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$dateControl = $_POST['dateControl'];
// Fetch data from the database
switch ($dateControl) {
    case 'Daily':
        // Your existing SQL query remains the same for 'Daily' control
        $sql = "SELECT * FROM inventoryrecords 
        INNER JOIN products ON inventoryrecords.prodid = products.prodid 
        ORDER BY dateentry DESC";
        break;
        case 'Weekly':
            // Assuming the 'dateentry' column represents the date and 'purchased' and 'released' are the values to be summed
            $sql = "SELECT CONCAT(
                DATE_FORMAT(MIN(ir.dateentry - INTERVAL WEEKDAY(ir.dateentry) DAY), '%M %e'),
                ' - ',
                DATE_FORMAT(MAX(ir.dateentry - INTERVAL (WEEKDAY(ir.dateentry) - 6) DAY), '%M %e, %Y')
            ) as dateentry, ir.prodid,
            SUM(ir.purchased) as purchased, 
            SUM(ir.released) as released,
            p.*
        FROM inventoryrecords ir
        INNER JOIN products p ON ir.prodid = p.prodid
        GROUP BY YEAR(ir.dateentry), WEEK(ir.dateentry), ir.prodid";

            break;
    case 'Monthly':
        // Fetch sum of purchased and released for all months for 'Monthly' control
        $sql = "SELECT 
            CONCAT(DATE_FORMAT(ir.dateentry, '%M %Y')) as dateentry,
            ir.prodid,
            SUM(ir.purchased) as purchased, 
            SUM(ir.released) as released,
            p.*
        FROM inventoryrecords ir
        INNER JOIN products p ON ir.prodid = p.prodid
        WHERE YEAR(ir.dateentry) = YEAR(NOW())  -- Filters by the current year
        GROUP BY DATE_FORMAT(ir.dateentry, '%Y-%m'), ir.prodid";

        break;
}
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
