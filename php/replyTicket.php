<?php 
date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippine Time
$conn = mysqli_connect("localhost","root","","demopos");

// foreach ($_POST as $key => $value) {
//     echo $key . ': ' . $value . '<br>';
// }



if($conn){

        $ticketID = $_POST['ticketID'];
        $customerID = $_POST['customerID'];
        $orderID = $_POST['orderID'];
        $category = $_POST['category'];
        $message = $_POST['message'];
        $dtm = $_POST['dtm'];

        $role = $_POST['role'];
        $userid = $_POST['userid'];


            $sql = "UPDATE tickets 
            SET `status` = 'Unsettled'
            WHERE ticketid = '$ticketID'";

            $sqlReply = "INSERT INTO `ticketreply`
            (`ticketid`, `userid`, `orderid`, `issue`, `state`, `message`, `datetimetickrep`, `readstatus`) 
            VALUES ('$ticketID', '$customerID', '$orderID', '$category', 'Receive', '$message', '$dtm', 'Read')";

            if ($conn->query($sql) === TRUE && $conn->query($sqlReply)) {
                // echo "Data inserted successfully";
                // After successful insertion, return a JSON response
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $response = array('success' => true,
                              'ticketID' => $ticketID);
            echo json_encode($response);
        
    
    

    $conn->close();
    
    }else{
    
        echo "ERROR: Data base is not connected...";
    
    }


 ?>