<?php 
date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippine Time
$conn = mysqli_connect("localhost","root","","demopos");

if($conn){ 

    $rfid = $_POST['rfid'];
    // $rfid = '10095558562';


    $sql = "SELECT * FROM onlineorder WHERE rfid = '$rfid'";
    $sqlres = $conn->query($sql);

    if ($sqlres && $sqlres->num_rows > 0){
        echo "DATA FOUND";

        while($row = $sqlres->fetch_assoc()){

            $prodid = $row['productid'];
            $orderquantity = $row['quantity'];
            $prodorderid = $row['productorderid'];

            $sqlAddonFind = "SELECT * FROM onlineaddon WHERE productorderid ='$prodorderid' AND prodname LIKE '%Wings%'";
            $sqlAddonRes = $conn->query($sqlAddonFind);

            if ($sqlAddonRes && $sqlAddonRes->num_rows > 0){
                echo "Add-on Found";
                while ($rowaddon = $sqlAddonRes->fetch_assoc()){
                    $addonQuantity = $rowaddon['quantity'];

                    $sqlUpdateInventory = "UPDATE products 
                    SET productsize = productsize - $addonQuantity 
                    WHERE prodname LIKE '%Wings%'";
                    $conn->query($sqlUpdateInventory);



                    // Modify the SQL query for $sql2
                    // Check if a record with the same date exists
                    $checkSql = "SELECT COUNT(*) AS count FROM inventoryrecords WHERE prodname LIKE '%Wings%' AND dateentry = '$currentDate'";
                    $rsCheck = $conn->query($checkSql);

                    if ($rsCheck && $rsCheck->num_rows > 0) {
                        $rsCheckRow = $rsCheck->fetch_assoc();
                        $recordCount = $rsCheckRow['count'];

                        if ($recordCount > 0) {
                            // Update the existing record
                            $updateSql = "UPDATE inventoryrecords 
                                        SET timeentry = '$currentTime',released = released + $addonQuantity, updateentry = 'Material Released'
                                        WHERE prodname LIKE '%Wings%' AND dateentry = '$currentDate'";
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


            $sqlProductFind = "SELECT * FROM productmaterials WHERE prodid = '$prodid'";
            $prodFindRes = $conn->query($sqlProductFind);

            if ($prodFindRes && $prodFindRes->num_rows > 0){
                echo "Material Found";
                while ($rowmat = $prodFindRes->fetch_assoc()){
                    $matId = $rowmat['prodmatid'];

                    $matQuantity = $orderquantity * $rowmat['quantity'];
                    $sqlUpdateInventory = "UPDATE products 
                    SET productsize = productsize - $matQuantity 
                    WHERE prodid = '$matId'";


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
                                        SET timeentry = '$currentTime',released = released + $matQuantity, updateentry = 'Material Released'
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


            $sqlStyro = "SELECT * FROM products WHERE prodname = 'Styro'";
            $styroRes = $conn->query($sqlStyro);
            
            if ($styroRes && $styroRes->num_rows > 0){
                while ($rowstyro = $styroRes->fetch_assoc()){
                    $styroid = $rowstyro['prodid'];


                    $updateStyro = "UPDATE products SET productsize = productsize - $orderquantity WHERE prodid = '$styroid'";
                    $conn->query($updateStyro);


                    // Modify the SQL query for $sql2
                    // Check if a record with the same date exists
                    $checkSql = "SELECT COUNT(*) AS count FROM inventoryrecords WHERE prodid = '$styroid' AND dateentry = '$currentDate'";
                    $rsCheck = $conn->query($checkSql);

                    if ($rsCheck && $rsCheck->num_rows > 0) {
                        $rsCheckRow = $rsCheck->fetch_assoc();
                        $recordCount = $rsCheckRow['count'];

                        if ($recordCount > 0) {
                            // Update the existing record
                            $updateSql = "UPDATE inventoryrecords 
                                        SET timeentry = '$currentTime',released = released + $orderQuantity, updateentry = 'Material Released'
                                        WHERE prodid = '$styroid' AND dateentry = '$currentDate'";
                            $conn->query($updateSql);
                        } else {
                            // Insert a new record
                            $insertSql = "INSERT INTO inventoryrecords (prodid, dateentry, timeentry, purchased, released, updateentry)
                                        VALUES ('$styroid', '$currentDate', '$currentTime', '0', '$orderQuantity', 'Material Released')";
                            $conn->query($insertSql);
                        }
                    }


                }

                
            }

        }

    }
     
}



 ?>