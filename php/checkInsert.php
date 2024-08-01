<?php 
date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippine Time
    $conn = mysqli_connect("localhost","root","","demopos");

    if($conn){

        $prodName = $_POST['prodName'];
        $prodSize = $_POST['prodSize'];
        $prodVariant = $_POST['prodVariant'];

        $sql = "SELECT * FROM products WHERE prodname = '$prodName' AND productsize = '$prodSize'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $response = array('success' => true);
            echo json_encode($response);
        }else{
            $response = array('success' => false);
            echo json_encode($response);
        }

        $conn->close();


    }


    ?>