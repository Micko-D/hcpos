<?php 
date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippine Time
$conn = mysqli_connect("localhost","root","","demopos");

// foreach ($_POST as $key => $value) {
//     echo $key . ': ' . $value . '<br>';
// }

//     $currentDateTime = date("Y-m-d H:i:s");
//     echo $currentDateTime;


if($conn){
    echo "success <br>";


    $currentDateTime = date("Y-m-d H:i:s");
    echo $currentDateTime;
        $chatID = $_POST['chatID'];
        $message = $_POST['message'];
        
        $userid = $_POST['userid'];

        $sql = "INSERT INTO `messages`(`conversationid`, `userid`, `state`, `message`, `datetimemess`, `readstatus`) 
        VALUES ('$chatID', '$userid', 'Sent', '$message', '$currentDateTime', 'Read')";

        
        

        if ($conn->query($sql) === TRUE) {
            echo "Message Sent successfully";
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