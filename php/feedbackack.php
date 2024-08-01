<?php 
date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippine Time
$conn = mysqli_connect("localhost","root","","demopos");

// foreach ($_POST as $key => $value) {
//     echo $key . ': ' . $value . '<br>';
// }



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
        $feedID = $_POST['feedID'];
        
        $role = $_POST['role'];
        $userid = $_POST['userid'];

        $sql = "UPDATE feedback 
        SET acknowledge = 'Acknowledge'
        WHERE id = '$feedID'";

        $auditSql = "INSERT INTO `audit` (`role`, userid, `date`, `time`, fromdev, `action`, prodname, info)
        VALUES ('$role', '$userid', '$currentDate', '$currentTime', '$device', 'Feedback Acknowledge', '$feedID', 'User')";


        

        if ($conn->query($sql) === TRUE && $conn->query($auditSql)) {
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