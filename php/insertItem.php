    <?php 
date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippine Time
    $conn = mysqli_connect("localhost","root","","demopos");

    if($conn){
        echo "success <br>";

        $randomNumber = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $itemName = $conn->real_escape_string($_POST['itemName']);
        $itemQuantity = floatval($_POST['itemQuantity']); // Convert to float

        echo $randomNumber. "<br>" . $itemName . "<br>" . $itemQuantity;

        // Handle image upload
        $targetDir = "../uploads/"; // Define the target directory to save uploaded images
        $targetFile = $targetDir . basename($_FILES["file"]["name"]);
        move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile);
        $fileName = basename($_FILES["file"]["name"]);

        $sql = "INSERT INTO products (prodid, prodname, producttype, productvariant, productsize, productprice, productimg) VALUES ('$randomNumber', '$itemName', 'Inventory', 'Inventory', '$itemQuantity', '0', '$fileName')";

        $currentDate = date("Y-m-d");
        $sql2 = "INSERT INTO inventoryrecords (prodid, dateentry, purchased, released, updateentry) VALUE ('$randomNumber', '$currentDate', $itemQuantity, '0', 'Material Created')";

        if ($conn->query($sql) === TRUE && $conn->query($sql2)) {
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