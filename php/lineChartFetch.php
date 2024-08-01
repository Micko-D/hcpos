<?php
// Create connection
$conn = mysqli_connect("localhost","root","","demopos");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$startDate = $_POST['startDate']; // Get the start date from the AJAX request
$endDate = $_POST['endDate'];     // Get the end date from the AJAX request
$materials = $_POST['categories'];
// $startDate = "2023-06-01"; // Get the start date from the AJAX request
// $endDate = "2023-010-03";     // Get the end date from the AJAX request
// $materials = ['Extra Small Cup', 'Small Cup', 'Large Cup', 'Straw', 'Parchment Paper', 'Plastic Cutlery', 'Styro'];

// Debugging: Log received dates
error_log("Received startDate: $startDate");
error_log("Received endDate: $endDate");

// $sql = "SELECT prodname, DATE_FORMAT(dateentry, '%M %Y) as month_year, released
//           FROM inventoryrecords JOIN products ON inventoryrecords.prodid = products.prodid
//           WHERE dateentry BETWEEN '$startDate' AND '$endDate' AND prodname NOT LIKE '%Wing%'
//           GROUP BY month_year
//           ORDER BY dateentry";

$sql = "SELECT 
            REPLACE(REPLACE(REPLACE(prodname, '12Oz. ', ''), '16Oz. ', ''), '22Oz. ', '') as prodname,
            DATE_FORMAT(dateentry, '%M %Y') as month_year,
            SUM(released) as released
        FROM 
            inventoryrecords
        JOIN 
            products ON inventoryrecords.prodid = products.prodid
        WHERE 
            dateentry BETWEEN '$startDate' AND '$endDate'
            AND prodname IN ('" . implode("', '", $materials) . "')
        GROUP BY 
            prodname, month_year
        ORDER BY 
            dateentry;";

$result = $conn->query($sql);

if ($result) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            "prodname" => $row['prodname'],
            "month_year" => $row['month_year'],
            "released" => $row['released'],
            "backgroundColor" => ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']
        );
    }

    
} else {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(array("error" => "Database query error"));
}

if (empty($data)) {
    $data[] = array(
        "prodname" => 'No Data',
        "month_year" => 'No Data',
        "released" => '0',
        "backgroundColor" => ['#000']
    );

}


header('Content-Type: application/json');
    echo json_encode($data);

// Close the database connection
$conn->close();

?>
