<?php 
date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippine Time
$conn = mysqli_connect("localhost","root","","demopos");

if($conn){
    echo "success <br>";

    // Function to check if the user-agent indicates a mobile device
function isMobileDevice() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $mobileKeywords = array('Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone');

    foreach ($mobileKeywords as $keyword) {
        if (stripos($userAgent, $keyword) !== false) {
            return true;
        }
    }

    return false;
}

// Check if the current device is mobile
if (isMobileDevice()) {
    $device = "Mobile";
} else {
    $device = "Web";
}

    $prodid = $_POST['prodid'];
    $cquantity = $_POST['currentQuantity'];
    $aquantity = $_POST['addQuantity'];
    $prodname = $_POST['prodname'];

    $role = $_POST['role'];
    $userid = $_POST['userid'];

    echo "PHP RECEIVE " . $role . $userid;

    $newQuantity = $cquantity + $aquantity;

    $sql = "UPDATE products SET productsize='$newQuantity' WHERE prodid = '$prodid'";

    $currentDate = date("Y-m-d");
    $currentTime = date("H:i:s");
    
    // Check if a record with the same date exists
    $checkSql = "SELECT COUNT(*) AS count FROM inventoryrecords WHERE prodid = '$prodid' AND dateentry = '$currentDate'";
    $result = $conn->query($checkSql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $recordCount = $row['count'];

        if ($recordCount > 0) {
            // Update the existing record
            $updateSql = "UPDATE inventoryrecords 
                          SET purchased = purchased + $aquantity, updateentry = 'Material Purchased (ADDED)'
                          WHERE prodid = '$prodid' AND dateentry = '$currentDate'";

            $auditSql = "INSERT INTO `audit` (`role`, userid, `date`, `time`, fromdev, `action`, prodname, info)
            VALUES ('$role', '$userid', '$currentDate', '$currentTime', '$device', 'Inventory Entry', '$prodname', 'POS')";
            if ($conn->query($updateSql) === TRUE && $conn->query($auditSql) === TRUE){
                echo "update success";
            }else{
                echo "error update <br><br><br> ";
                echo $auditSql;
            }
        } else {
            // Insert a new record
            $insertSql = "INSERT INTO inventoryrecords (prodid, dateentry, purchased, released, updateentry)
                          VALUES ('$prodid', '$currentDate', $aquantity, '0', 'Material Purchased (ADDED)')";

            $auditSql = "INSERT INTO `audit` (`role`, userid, `date`, `time`, fromdev, `action`, prodname, info)
            VALUES ('$role', '$userid', '$currentDate', '$currentTime', '$device', 'Inventory Entry', '$prodname', 'POS')";

            if ($conn->query($insertSql) === TRUE && $conn->query($auditSql) === TRUE){
                echo "insert success";
            }else{
                echo "error update <br><br><br>";
                echo $auditSql . "<br>";
                echo mysqli_error($conn);

            }
            
        }
    }

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted/updated successfully";
        // After successful insertion/update, return a JSON response
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $response = array('success' => true);
echo json_encode($response);

    $conn->close();
    
    }else{
    
        echo "ERROR: Data base is not connected...";
    
    }


 ?>