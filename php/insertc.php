<?php 
date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippine Time
$conn = mysqli_connect("localhost","root","","demopos");

if($conn){
    echo "success <br>";

    $itemName = $conn->real_escape_string($_POST['itemName']);
    $itemType = $conn->real_escape_string($_POST['itemType']);
    $variantsJSON = $_POST['variants']; // 'variants' should be a JSON string

        // Decode the JSON string to an array
        $variants = json_decode($variantsJSON);

    echo $itemName. "<br>" . $itemType ."<br>";
    // Check if $variants is an array before using implode
    if (is_array($variants)) {
        echo "Yes Array Variants: " . implode(', ', $variants) . "<br>";

        foreach($variants as $variant){
            echo $variant."<br>";

                $sql = "INSERT INTO itemscreated (itemname, itemtype, itemvariant) VALUES ('$itemName', '$itemType', '$variant')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully";
        // After successful insertion, return a JSON response
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
            
        }
        $response = array('success' => true);
        echo json_encode($response);
    } else {
        echo "No Array Variants: $variants <br>"; // Output as is if not an array
    }



    $conn->close();
    
    }else{
    
        echo "ERROR: Data base is not connected...";
    
    }


 ?>