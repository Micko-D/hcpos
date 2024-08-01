<?php
session_start();
date_default_timezone_set('Asia/Manila'); // Set the time zone to Philippine Time

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




    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // $username = 'Ashlyn';
    // $password = 'cashier1';

    // echo $username. " " . $password;

    // Query to fetch the hashed password for the given username
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    // echo $sql . "<br>";
    

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['accpassword'];
        $role = $row['accrole'];
        $userid = $row['userid'];
        // echo json_encode($row);
        // echo $hashedPassword;

        // Verify the hashed password
        if ($password === $hashedPassword) {
            $auditSql = "INSERT INTO `audit` (`role`, userid, `date`, `time`, `fromdev`, `action`, `prodname`, `info`)
            VALUES ('$role', '$userid', '$currentDate', '$currentTime', '$device', 'Logged In', '', 'Login')";
            $conn->query($auditSql);
            // Successful login
            // Return data as JSON response
            $response = array('success' => true, 'role' => $row['accrole'], 'userid' => $row['userid']);
            echo json_encode($response);
            $_SESSION['user_id'] = $row['id'];
            // echo "success";
        } else {
            // Invalid password
            // Return data as JSON response
            $response = array('success' => false, 'message' => 'Invalid password');
            echo json_encode($response);
            // echo "invalid";
        }
    } else {
        // User not found
        // Return data as JSON response
        $response = array('success' => false, 'message' => 'User not found');
        echo json_encode($response);
        // echo "not_found";
    }


$conn->close();
?>
