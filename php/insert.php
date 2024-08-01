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

    $currentDate = date("Y-m-d");
    $currentTime = date("H:i:s");

    $randomNumber = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $itemName = $conn->real_escape_string($_POST['itemName']);
    $itemType = $conn->real_escape_string($_POST['itemType']);
    $itemVariant = $conn->real_escape_string($_POST['variant']);
    $itemServing = $conn->real_escape_string($_POST['serving']);
    // $itemVariant = 'Bilao Small';
    $itemPrice = floatval($_POST['itemPrice']); // Convert to float

    // $matid = $conn->real_escape_string($_POST['materialId']);
    // $matQuantity = $conn->real_escape_string($_POST['materialQuantity']);

    

    // Handle image upload
    $targetDir = "../uploads/"; // Define the target directory to save uploaded images
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);
    move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile);
    $fileName = basename($_FILES["file"]["name"]);

    $sql = "INSERT INTO products (prodid, prodname, producttype, productvariant, productsize, productprice, productimg) VALUES ('$randomNumber', '$itemName', '$itemType', '$itemVariant', '$itemServing', $itemPrice, '$fileName')";

    $materialsListJson = $_POST['materialsId'];

    $materialsList = json_decode($materialsListJson, true); // Decode JSON string into an associative array
    if (is_array($materialsList)){
    foreach ($materialsList as $materialGroup) {
        $materialId = $materialGroup['materialId'];
        $quantity = $materialGroup['quantity'];
    
        $sqll = "INSERT INTO productmaterials (prodid, prodmatid, quantity) VALUES ('$randomNumber', '$materialId', '$quantity')";
        echo "SUCCESS INSERT MATERIALS";
    
        if (!$conn->query($sqll)) {
            // If any insertion fails, set $success to false
            $success = false;
        }
    }
}else{
    echo "NOT ARRAY MATERIAL LIST";
}

    $auditSql = "INSERT INTO `audit` (`role`, userid, `date`, `time`, fromdev, `action`, prodname, info)
        VALUES ('$role', '$userid', '$currentDate', '$currentTime', '$device', 'Insert Product', '$prodnamesize', 'POS')";

    if ($conn->query($sql) === TRUE && $conn->query($auditSql) === TRUE) {
        echo "Data inserted successfully";
        // After successful insertion, return a JSON response
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