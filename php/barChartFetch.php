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
$materials = $_POST['categories'];
// $materials = ['Extra Small Cup', 'Small Cup', 'Large Cup', 'Straw', 'Parchment Paper', 'Plastic Cutlery', 'Styro'];
// $salesType = 'Monthly';

// echo "Materials: ";
// print_r($materials);

$sql = "SELECT 
            inventoryrecords.prodid, 
            REPLACE(REPLACE(REPLACE(prodname, '12Oz. ', ''), '16Oz. ', ''), '22Oz. ', '') as prodname,
            dateentry, 
            ROUND(AVG(released), 1) as avgreleased 
        FROM 
            inventoryrecords 
        JOIN 
            products ON inventoryrecords.prodid = products.prodid
        WHERE ";

if ($salesType === 'Daily') {
    $sql .= " DATE(dateentry) = CURDATE() AND prodname IN ('" . implode("', '", $materials) . "')
     GROUP BY prodid";
} elseif ($salesType === 'Monthly') {
    $sql .= " YEAR(dateentry) = $currentYear AND MONTH(dateentry) = MONTH(CURDATE())  AND prodname IN ('" . implode("', '", $materials) . "')
GROUP BY inventoryrecords.prodid, YEAR(dateentry), MONTH(dateentry)";
} elseif ($salesType === 'Yearly') {
    $sql .= "prodname IN ('" . implode("', '", $materials) . "')
    GROUP BY prodid, YEAR(dateentry)";
}

        
        $result = $conn->query($sql);
        if ($result) {
    $data = array(); // Create an array to store the data

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data['labels'][] = $row['prodname'];
            $data['datasets'][0]['data'][] = $row['avgreleased'];
        }
        $data['labels'][] = '';
        $data['datasets'][0]['data'][] = 0;

        // Set colors for the doughnut chart
    $colors = ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'];
    $data['datasets'][0]['backgroundColor'] = $colors;
    } else {
        $data['labels'] = array();
        $data['datasets'][0]['data'] = array();
    }

    

    // Encode the data array as JSON
    echo json_encode($data);
} else {
    // Handle any errors that occurred during the query
    echo "Error: " . $conn->error;
}

?>
