<?php 
date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippine Time
$conn = mysqli_connect("localhost","root","","demopos");

if($conn){
    echo "success <br>";

    $inputJSON = file_get_contents('php://input');
    $data = json_decode($inputJSON, true);

    $userid = $data['userid'];
    $customerName = $data['customerName'];
    $orderNumber = $data['orderNumber'];
    $rfid = $data['rfid'];
    $orderType = $data['selectedDineValue'];
    $discount = ($data['seniorDiscount'] ? '0.2' : '');
    $paymentVlaue = $data['paymentValue'];
    $finalTotalValue = $data['finalTotalValue'];
    $changeValue = $data['changeValue'];

    $cardNumber = $data['cardNumber'];
    echo $customerName . "<br>" . $orderNumber . "<br>" . $rfid . "<br>" . $orderType . "<br>" . $discount . "<br>" . $paymentVlaue . "<br>" . $finalTotalValue . "<br>" . $changeValue ;

    

    echo json_encode($data);
    $currentDate = date("Y-m-d");
    $currentTime = $data['orderTime'];

    // Create a DateTime object from the string
$orderTime = DateTime::createFromFormat('m/d/Y, h:i:s A', $currentTime);

// Check if the parsing was successful
if ($orderTime !== false) {
    // Format and echo the time
    $currentTime = $orderTime->format('H:i:s');
    echo $currentTime;
} else {
    echo "Invalid date format";
}
    // Loop through selected items

    
    if ($orderType === "Dine-In"){
        echo "Selected Items:<br>";
foreach ($data['itemDetailsArray'] as $selectedItem) {
    echo "Product ID: " . $selectedItem['prodid'] . "<br>";
    echo "Quantity: " . $selectedItem['quantity'] . "<br>";
    echo "Subtotal: " . $selectedItem['subtotal'] . "<br>";

        $prodid = $selectedItem['prodid'];
        $quantity = $selectedItem['quantity'];
        $subtotal = $selectedItem['subtotal'];

    $string = $selectedItem['prodid'];
$parts = explode('-', $string); // Split the string by "-"
$itemRealId = $parts[0]; // Reconstruct the string without the number

echo "<br> Real Id NO Extension" . $itemRealId. "<br>";

    // Loop through addons for the current item
    echo "Add-ons:<br>";
    foreach ($selectedItem['addons'] as $addon) {
        echo "Addon Name: " . $addon['name'] . "<br>";
        echo "Addon Price: " . $addon['price'] . "<br>";
        echo "Addon Quantity: " . $addon['quantity'] . "<br>";
        echo "Addon Subtotal: " . $addon['subtotal'] . "<br>";

        $addonname = $addon['name'];
        $addonquantity = $addon['quantity'];
        $addonprice = $addon['price'];
        $addonsubtotal = $addon['subtotal'];

        $sqll = "INSERT INTO addonorder (orderid, productorderid, addonname, quantity, price, subtotal) VALUES ('$orderNumber', '$prodid', '$addonname', '$addonquantity', '$addonprice', '$addonsubtotal')";

        $materialCheckSql = "SELECT * FROM productmaterials WHERE prodid = '$itemRealId'";
        $matResult = $conn->query($materialCheckSql);

        if ($matResult->num_rows > 0){
            while($row = $matResult->fetch_assoc()){

                $matId = $row['prodmatid'];
                $multW = 1 * $addonquantity;
            $sqlllll = "UPDATE products
            SET productsize = productsize - $multW
            WHERE prodid = '$matId' AND producttype = 'Inventory';";
            $conn->query($sqlllll);

                    // Modify the SQL query for $sql2
                    // Check if a record with the same date exists
                    $checkSql = "SELECT COUNT(*) AS count FROM inventoryrecords WHERE prodid = '$matId' AND dateentry = '$currentDate'";
                    $rsCheck = $conn->query($checkSql);

                    if ($rsCheck && $rsCheck->num_rows > 0) {
                        $rsCheckRow = $rsCheck->fetch_assoc();
                        $recordCount = $rsCheckRow['count'];

                        if ($recordCount > 0) {
                            // Update the existing record
                            $updateSql = "UPDATE inventoryrecords 
                                        SET timeentry = '$currentTime',released = released + 1, updateentry = 'Material Released'
                                        WHERE prodid = '$matId' AND dateentry = '$currentDate'";
                            $conn->query($updateSql);
                        } else {
                            // Insert a new record
                            $insertSql = "INSERT INTO inventoryrecords (prodid, dateentry, timeentry, purchased, released, updateentry)
                                        VALUES ('$matId', '$currentDate', '$currentTime', '0', '1', 'Material Released')";
                            $conn->query($insertSql);
                        }
                    }
             

            }
        }

            if ($conn->query($sqll) === TRUE) {
                echo "Data inserted successfully";
                // After successful insertion, return a JSON response
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }

$sql = "INSERT INTO orders (orderid, userid, rfid, customername, productid, productorderid, quantity, subtotal, discount, cardnumber, payment, totalprice, changepay, orderstatus, ordertype, orderdate, ordertime) VALUES ('$orderNumber', '$userid', '$rfid', '$customerName', '$itemRealId', '$prodid', '$quantity', '$subtotal', '$discount', '$cardNumber','$paymentVlaue', '$finalTotalValue','$changeValue', '$orderType', '$orderType', '$currentDate', '$currentTime')";

$sqlll = "SELECT * FROM products WHERE prodid = '$itemRealId'";
$result = $conn->query($sqlll);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['productsize'] === '12Oz.'){
            $multPP = 1 * $quantity;

            $sqllll = "UPDATE products
            SET productsize = productsize - $multPP
            WHERE prodname LIKE '%12Oz%' AND producttype = 'Inventory';";

            $conn->query($sqllll);


            $sqlfetchPP = "SELECT * FROM products WHERE prodname LIKE '%12Oz%' AND producttype = 'Inventory'";
            $rsPP = $conn->query($sqlfetchPP);
            if ($rsPP->num_rows > 0){
                while ($rsRow = $rsPP->fetch_assoc()){
                    $invID = $rsRow['prodid'];
                    
                    // Modify the SQL query for $sql2
                    // Check if a record with the same date exists
                    $checkSql = "SELECT COUNT(*) AS count FROM inventoryrecords WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                    $rsCheck = $conn->query($checkSql);

                    if ($rsCheck && $rsCheck->num_rows > 0) {
                        $rsCheckRow = $rsCheck->fetch_assoc();
                        $recordCount = $rsCheckRow['count'];

                        if ($recordCount > 0) {
                            // Update the existing record
                            $updateSql = "UPDATE inventoryrecords 
                                        SET timeentry='$currentTime', released = released + $multPP, updateentry = 'Material Released'
                                        WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                            $conn->query($updateSql);
                        } else {
                            // Insert a new record
                            $insertSql = "INSERT INTO inventoryrecords (prodid, dateentry, timeentry, purchased, released, updateentry)
                                        VALUES ('$invID', '$currentDate', '$currentTime', '0', '$multPP', 'Material Released')";
                            $conn->query($insertSql);
                        }
                    }
                }
            }

        }else if ($row['productsize'] === '16Oz.'){
            $multPP = 1 * $quantity;

            $sqllll = "UPDATE products
            SET productsize = productsize - $multPP
            WHERE prodname LIKE '%16Oz%' AND producttype = 'Inventory';";

            $conn->query($sqllll);


            $sqlfetchPP = "SELECT * FROM products WHERE prodname LIKE '%16Oz%' AND producttype = 'Inventory'";
            $rsPP = $conn->query($sqlfetchPP);
            if ($rsPP->num_rows > 0){
                while ($rsRow = $rsPP->fetch_assoc()){
                    $invID = $rsRow['prodid'];
                    
                    // Modify the SQL query for $sql2
                    // Check if a record with the same date exists
                    $checkSql = "SELECT COUNT(*) AS count FROM inventoryrecords WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                    $rsCheck = $conn->query($checkSql);

                    if ($rsCheck && $rsCheck->num_rows > 0) {
                        $rsCheckRow = $rsCheck->fetch_assoc();
                        $recordCount = $rsCheckRow['count'];

                        if ($recordCount > 0) {
                            // Update the existing record
                            $updateSql = "UPDATE inventoryrecords 
                                        SET timeentry='$currentTime', released = released + $multPP, updateentry = 'Material Released'
                                        WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                            $conn->query($updateSql);
                        } else {
                            // Insert a new record
                            $insertSql = "INSERT INTO inventoryrecords (prodid, dateentry, timeentry, purchased, released, updateentry)
                                        VALUES ('$invID', '$currentDate', '$currentTime', '0', '$multPP', 'Material Released')";
                            $conn->query($insertSql);
                        }
                    }
                }
            }

        }else if ($row['productsize'] === '20Oz.' || $row['productsize'] === '22Oz.'){
            $multPP = 1 * $quantity;

            $sqllll = "UPDATE products
            SET productsize = productsize - $multPP
            WHERE prodname LIKE '%22Oz%' AND producttype = 'Inventory';";

            $conn->query($sqllll);


            $sqlfetchPP = "SELECT * FROM products WHERE prodname LIKE '%22Oz%' AND producttype = 'Inventory'";
            $rsPP = $conn->query($sqlfetchPP);
            if ($rsPP->num_rows > 0){
                while ($rsRow = $rsPP->fetch_assoc()){
                    $invID = $rsRow['prodid'];
                    
                    // Modify the SQL query for $sql2
                    // Check if a record with the same date exists
                    $checkSql = "SELECT COUNT(*) AS count FROM inventoryrecords WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                    $rsCheck = $conn->query($checkSql);

                    if ($rsCheck && $rsCheck->num_rows > 0) {
                        $rsCheckRow = $rsCheck->fetch_assoc();
                        $recordCount = $rsCheckRow['count'];

                        if ($recordCount > 0) {
                            // Update the existing record
                            $updateSql = "UPDATE inventoryrecords 
                                        SET timeentry='$currentTime', released = released + $multPP, updateentry = 'Material Released'
                                        WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                            $conn->query($updateSql);
                        } else {
                            // Insert a new record
                            $insertSql = "INSERT INTO inventoryrecords (prodid, dateentry, timeentry, purchased, released, updateentry)
                                        VALUES ('$invID', '$currentDate', '$currentTime', '0', '$multPP', 'Material Released')";
                            $conn->query($insertSql);
                        }
                    }
                }
            }

        }else{

            
            
            $multPP = 1 * $quantity;
            $sqllll = "UPDATE products
            SET productsize = productsize - $multPP
            WHERE prodname = 'Parchment Paper' AND producttype = 'Inventory';";            
            $conn->query($sqllll);
  

            $sqlfetchPP = "SELECT * FROM products WHERE prodname = 'Parchment Paper' AND producttype = 'Inventory'";
            $rsPP = $conn->query($sqlfetchPP);
            if ($rsPP->num_rows > 0){
                while ($rsRow = $rsPP->fetch_assoc()){
                    $invID = $rsRow['prodid'];
                    
                    // Modify the SQL query for $sql2
                    // Check if a record with the same date exists
                    $checkSql = "SELECT COUNT(*) AS count FROM inventoryrecords WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                    $rsCheck = $conn->query($checkSql);

                    if ($rsCheck && $rsCheck->num_rows > 0) {
                        $rsCheckRow = $rsCheck->fetch_assoc();
                        $recordCount = $rsCheckRow['count'];

                        if ($recordCount > 0) {
                            // Update the existing record
                            $updateSql = "UPDATE inventoryrecords 
                                        SET timeentry = '$currentTime', released = released + $multPP, updateentry = 'Material Released'
                                        WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                            $conn->query($updateSql);
                        } else {
                            // Insert a new record
                            $insertSql = "INSERT INTO inventoryrecords (prodid, dateentry, timeentry, purchased, released, updateentry)
                                        VALUES ('$invID', '$currentDate', '$currentTime', '0', '$multPP', 'Material Released')";
                            $conn->query($insertSql);
                        }
                    }
                }
            }

        $materialCheckSql = "SELECT * FROM productmaterials WHERE prodid = '$itemRealId'";
        $matResult = $conn->query($materialCheckSql);

        if ($matResult->num_rows > 0){
            while($row = $matResult->fetch_assoc()){

                $matId = $row['prodmatid'];
                $multW = $row['quantity'] * $quantity;
            $sqlllll = "UPDATE products
            SET productsize = productsize - $multW
            WHERE prodid = '$matId' AND producttype = 'Inventory';";
            $conn->query($sqlllll);

                    // Modify the SQL query for $sql2
                    // Check if a record with the same date exists
                    $checkSql = "SELECT COUNT(*) AS count FROM inventoryrecords WHERE prodid = '$matId' AND dateentry = '$currentDate'";
                    $rsCheck = $conn->query($checkSql);

                    if ($rsCheck && $rsCheck->num_rows > 0) {
                        $rsCheckRow = $rsCheck->fetch_assoc();
                        $recordCount = $rsCheckRow['count'];

                        if ($recordCount > 0) {
                            // Update the existing record
                            $updateSql = "UPDATE inventoryrecords 
                                        SET timeentry = '$currentTime',released = released + $multW, updateentry = 'Material Released'
                                        WHERE prodid = '$matId' AND dateentry = '$currentDate'";
                            $conn->query($updateSql);
                        } else {
                            // Insert a new record
                            $insertSql = "INSERT INTO inventoryrecords (prodid, dateentry, timeentry, purchased, released, updateentry)
                                        VALUES ('$matId', '$currentDate', '$currentTime', '0', '$multW', 'Material Released')";
                            $conn->query($insertSql);
                        }
                    }
             

            }
        }

        }
    }
}

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully";
    // After successful insertion, return a JSON response
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
    

    echo "<br>";
}
    }else{
        echo "Selected Items:<br>";
foreach ($data['itemDetailsArray'] as $selectedItem) {
    echo "Product ID: " . $selectedItem['prodid'] . "<br>";
    echo "Quantity: " . $selectedItem['quantity'] . "<br>";
    echo "Subtotal: " . $selectedItem['subtotal'] . "<br>";

        $prodid = $selectedItem['prodid'];
        $quantity = $selectedItem['quantity'];
        $subtotal = $selectedItem['subtotal'];

    $string = $selectedItem['prodid'];
$parts = explode('-', $string); // Split the string by "-"
$itemRealId = $parts[0]; // Reconstruct the string without the number

echo "<br> Real Id NO Extension" . $itemRealId. "<br>";

    // Loop through addons for the current item
    echo "Add-ons:<br>";
    foreach ($selectedItem['addons'] as $addon) {
        echo "Addon Name: " . $addon['name'] . "<br>";
        echo "Addon Price: " . $addon['price'] . "<br>";
        echo "Addon Quantity: " . $addon['quantity'] . "<br>";
        echo "Addon Subtotal: " . $addon['subtotal'] . "<br>";

        $addonname = $addon['name'];
        $addonquantity = $addon['quantity'];
        $addonprice = $addon['price'];
        $addonsubtotal = $addon['subtotal'];

        $sqll = "INSERT INTO addonorder (orderid, productorderid, addonname, quantity, price, subtotal) VALUES ('$orderNumber', '$prodid', '$addonname', '$addonquantity', '$addonprice', '$addonsubtotal')";

        $materialCheckSql = "SELECT * FROM productmaterials WHERE prodid = '$itemRealId'";
        $matResult = $conn->query($materialCheckSql);

        if ($matResult->num_rows > 0){
            while($row = $matResult->fetch_assoc()){

                $matId = $row['prodmatid'];
                $multW = 1 * $addonquantity;
            $sqlllll = "UPDATE products
            SET productsize = productsize - $multW
            WHERE prodid = '$matId' AND producttype = 'Inventory';";
            $conn->query($sqlllll);

                    // Modify the SQL query for $sql2
                    // Check if a record with the same date exists
                    $checkSql = "SELECT COUNT(*) AS count FROM inventoryrecords WHERE prodid = '$matId' AND dateentry = '$currentDate'";
                    $rsCheck = $conn->query($checkSql);

                    if ($rsCheck && $rsCheck->num_rows > 0) {
                        $rsCheckRow = $rsCheck->fetch_assoc();
                        $recordCount = $rsCheckRow['count'];

                        if ($recordCount > 0) {
                            // Update the existing record
                            $updateSql = "UPDATE inventoryrecords 
                                        SET timeentry = '$currentTime',released = released + 1, updateentry = 'Material Released'
                                        WHERE prodid = '$matId' AND dateentry = '$currentDate'";
                            $conn->query($updateSql);
                        } else {
                            // Insert a new record
                            $insertSql = "INSERT INTO inventoryrecords (prodid, dateentry, timeentry, purchased, released, updateentry)
                                        VALUES ('$matId', '$currentDate', '$currentTime', '0', '1', 'Material Released')";
                            $conn->query($insertSql);
                        }
                    }
             

            }
        }

            if ($conn->query($sqll) === TRUE) {
                echo "Data inserted successfully";
                // After successful insertion, return a JSON response
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
    }

$sql = "INSERT INTO orders (orderid, userid, rfid, customername, productid, productorderid, quantity, subtotal, discount, cardnumber, payment, totalprice, changepay, orderstatus, ordertype, orderdate, ordertime) VALUES ('$orderNumber', '$userid', '$rfid', '$customerName', '$itemRealId', '$prodid', '$quantity', '$subtotal', '$discount', '$cardNumber', '$paymentVlaue', '$finalTotalValue','$changeValue', '$orderType', '$orderType', '$currentDate', '$currentTime')";

$sqlll = "SELECT * FROM products WHERE prodid = '$itemRealId'";
$result = $conn->query($sqlll);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['productsize'] === '12Oz.'){
            $multPP = 1 * $quantity;

            $sqllll = "UPDATE products
            SET productsize = productsize - $multPP
            WHERE prodname LIKE '%12Oz%' AND producttype = 'Inventory';";

            $conn->query($sqllll);


            $sqlfetchPP = "SELECT * FROM products WHERE prodname LIKE '%12Oz%' AND producttype = 'Inventory'";
            $rsPP = $conn->query($sqlfetchPP);
            if ($rsPP->num_rows > 0){
                while ($rsRow = $rsPP->fetch_assoc()){
                    $invID = $rsRow['prodid'];
                    
                    // Modify the SQL query for $sql2
                    // Check if a record with the same date exists
                    $checkSql = "SELECT COUNT(*) AS count FROM inventoryrecords WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                    $rsCheck = $conn->query($checkSql);

                    if ($rsCheck && $rsCheck->num_rows > 0) {
                        $rsCheckRow = $rsCheck->fetch_assoc();
                        $recordCount = $rsCheckRow['count'];

                        if ($recordCount > 0) {
                            // Update the existing record
                            $updateSql = "UPDATE inventoryrecords 
                                        SET timeentry='$currentTime', released = released + $multPP, updateentry = 'Material Released'
                                        WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                            $conn->query($updateSql);
                        } else {
                            // Insert a new record
                            $insertSql = "INSERT INTO inventoryrecords (prodid, dateentry, timeentry, purchased, released, updateentry)
                                        VALUES ('$invID', '$currentDate', '$currentTime', '0', '$multPP', 'Material Released')";
                            $conn->query($insertSql);
                        }
                    }
                }
            }

        }else if ($row['productsize'] === '16Oz.'){
            $multPP = 1 * $quantity;

            $sqllll = "UPDATE products
            SET productsize = productsize - $multPP
            WHERE prodname LIKE '%16Oz%' AND producttype = 'Inventory';";

            $conn->query($sqllll);


            $sqlfetchPP = "SELECT * FROM products WHERE prodname LIKE '%16Oz%' AND producttype = 'Inventory'";
            $rsPP = $conn->query($sqlfetchPP);
            if ($rsPP->num_rows > 0){
                while ($rsRow = $rsPP->fetch_assoc()){
                    $invID = $rsRow['prodid'];
                    
                    // Modify the SQL query for $sql2
                    // Check if a record with the same date exists
                    $checkSql = "SELECT COUNT(*) AS count FROM inventoryrecords WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                    $rsCheck = $conn->query($checkSql);

                    if ($rsCheck && $rsCheck->num_rows > 0) {
                        $rsCheckRow = $rsCheck->fetch_assoc();
                        $recordCount = $rsCheckRow['count'];

                        if ($recordCount > 0) {
                            // Update the existing record
                            $updateSql = "UPDATE inventoryrecords 
                                        SET timeentry='$currentTime', released = released + $multPP, updateentry = 'Material Released'
                                        WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                            $conn->query($updateSql);
                        } else {
                            // Insert a new record
                            $insertSql = "INSERT INTO inventoryrecords (prodid, dateentry, timeentry, purchased, released, updateentry)
                                        VALUES ('$invID', '$currentDate', '$currentTime', '0', '$multPP', 'Material Released')";
                            $conn->query($insertSql);
                        }
                    }
                }
            }

        }else if ($row['productsize'] === '20Oz.' || $row['productsize'] === '22Oz.'){
            $multPP = 1 * $quantity;

            $sqllll = "UPDATE products
            SET productsize = productsize - $multPP
            WHERE prodname LIKE '%22Oz%' AND producttype = 'Inventory';";

            $conn->query($sqllll);


            $sqlfetchPP = "SELECT * FROM products WHERE prodname LIKE '%22Oz%' AND producttype = 'Inventory'";
            $rsPP = $conn->query($sqlfetchPP);
            if ($rsPP->num_rows > 0){
                while ($rsRow = $rsPP->fetch_assoc()){
                    $invID = $rsRow['prodid'];
                    
                    // Modify the SQL query for $sql2
                    // Check if a record with the same date exists
                    $checkSql = "SELECT COUNT(*) AS count FROM inventoryrecords WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                    $rsCheck = $conn->query($checkSql);

                    if ($rsCheck && $rsCheck->num_rows > 0) {
                        $rsCheckRow = $rsCheck->fetch_assoc();
                        $recordCount = $rsCheckRow['count'];

                        if ($recordCount > 0) {
                            // Update the existing record
                            $updateSql = "UPDATE inventoryrecords 
                                        SET timeentry='$currentTime', released = released + $multPP, updateentry = 'Material Released'
                                        WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                            $conn->query($updateSql);
                        } else {
                            // Insert a new record
                            $insertSql = "INSERT INTO inventoryrecords (prodid, dateentry, timeentry, purchased, released, updateentry)
                                        VALUES ('$invID', '$currentDate', '$currentTime', '0', '$multPP', 'Material Released')";
                            $conn->query($insertSql);
                        }
                    }
                }
            }

        }else{
            
            $multPP = 1 * $quantity;
            $sqllll = "UPDATE products
            SET productsize = productsize - $multPP
            WHERE prodname = 'Styro' AND producttype = 'Inventory';";            
            $conn->query($sqllll);
  

            $sqlfetchPP = "SELECT * FROM products WHERE prodname = 'Styro' AND producttype = 'Inventory'";
            $rsPP = $conn->query($sqlfetchPP);
            if ($rsPP->num_rows > 0){
                while ($rsRow = $rsPP->fetch_assoc()){
                    $invID = $rsRow['prodid'];
                    
                    // Modify the SQL query for $sql2
                    // Check if a record with the same date exists
                    $checkSql = "SELECT COUNT(*) AS count FROM inventoryrecords WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                    $rsCheck = $conn->query($checkSql);

                    if ($rsCheck && $rsCheck->num_rows > 0) {
                        $rsCheckRow = $rsCheck->fetch_assoc();
                        $recordCount = $rsCheckRow['count'];

                        if ($recordCount > 0) {
                            // Update the existing record
                            $updateSql = "UPDATE inventoryrecords 
                                        SET timeentry = '$currentTime', released = released + $multPP, updateentry = 'Material Released'
                                        WHERE prodid = '$invID' AND dateentry = '$currentDate'";
                            $conn->query($updateSql);
                        } else {
                            // Insert a new record
                            $insertSql = "INSERT INTO inventoryrecords (prodid, dateentry, timeentry, purchased, released, updateentry)
                                        VALUES ('$invID', '$currentDate', '$currentTime', '0', '$multPP', 'Material Released')";
                            $conn->query($insertSql);
                        }
                    }
                }
            }

            $materialCheckSql = "SELECT * FROM productmaterials WHERE prodid = '$itemRealId'";
        $matResult = $conn->query($materialCheckSql);

        if ($matResult->num_rows > 0){
            while($row = $matResult->fetch_assoc()){

                $matId = $row['prodmatid'];
                $multW = $row['quantity'] * $quantity;
            $sqlllll = "UPDATE products
            SET productsize = productsize - $multW
            WHERE prodid = '$matId' AND producttype = 'Inventory';";
            $conn->query($sqlllll);

                    // Modify the SQL query for $sql2
                    // Check if a record with the same date exists
                    $checkSql = "SELECT COUNT(*) AS count FROM inventoryrecords WHERE prodid = '$matId' AND dateentry = '$currentDate'";
                    $rsCheck = $conn->query($checkSql);

                    if ($rsCheck && $rsCheck->num_rows > 0) {
                        $rsCheckRow = $rsCheck->fetch_assoc();
                        $recordCount = $rsCheckRow['count'];

                        if ($recordCount > 0) {
                            // Update the existing record
                            $updateSql = "UPDATE inventoryrecords 
                                        SET timeentry = '$currentTime',released = released + $multW, updateentry = 'Material Released'
                                        WHERE prodid = '$matId' AND dateentry = '$currentDate'";
                            $conn->query($updateSql);
                        } else {
                            // Insert a new record
                            $insertSql = "INSERT INTO inventoryrecords (prodid, dateentry, timeentry, purchased, released, updateentry)
                                        VALUES ('$matId', '$currentDate', '$currentTime', '0', '$multW', 'Material Released')";
                            $conn->query($insertSql);
                        }
                    }
             

            }
        }

        }
    }
}

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully";
    // After successful insertion, return a JSON response
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
    

    echo "<br>";
}
    }



    
}



 ?>