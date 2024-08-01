<?php 
date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippine Time
$conn = mysqli_connect("localhost","root","","demopos");

// foreach ($_POST as $key => $value) {
//     echo $key . ': ' . $value . '<br>';
// }



if($conn){
    echo "success <br>";


    $orderid = $_POST['orderid'];
    $updateStatus = $_POST['updateStatus'];

    $sql="UPDATE onlineorder SET orderstatus='".$updateStatus."' WHERE rfid='".$orderid."';";
    

    if ($conn->query($sql)) {
        echo "Data inserted successfully";
        // After successful insertion, return a JSON response
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }    
    
    $conn->close();
    
    }else{
    
        echo "ERROR: Data base is not connected...";
    
    }


 ?>