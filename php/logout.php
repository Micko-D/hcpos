<?php
session_start();
date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippine Time

// foreach ($_POST as $key => $value) {
//     echo $key . ': ' . $value . '<br>';
// }

// Database connection
$conn = mysqli_connect("localhost","root","","demopos");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

        $role = $_POST['role'];
        $userid = $_POST['userid'];

        $auditSql = "INSERT INTO `audit` (`role`, userid, `date`, `time`, fromdev, `action`, info)
        VALUES ('$role', '$userid', '$currentDate', '$currentTime', '$device', 'Logged Out', 'Login')";
        $conn->query($auditSql);


$conn->close();
?>
