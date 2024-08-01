<?php 

// $samplePassword = "ThisIsPassword";

// $enteredSamplePassword = "ThisIsPasswored";

// $hasedPassword = md5($samplePassword);
// $hasedEnteredPassword = md5($enteredSamplePassword);

// if ($hasedEnteredPassword === $hasedPassword){
//     echo "Password is correct";
// }else{
//     echo "Incorrect Password";
// }

$conn = mysqli_connect("localhost","root","","demopos");

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

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
    
        return $randomString;
    }
    
    // Example usage to generate a random string of length 12
    $randomString = generateRandomString(12);
    echo $randomString;
    $employeeName = $conn->real_escape_string($_POST['employeeName']);
    $employeeEmail = $conn->real_escape_string($_POST['employeeEmail']);
    $employeePassword = $conn->real_escape_string($_POST['employeePassword']);
    $employeeRole = $conn->real_escape_string($_POST['accrole']);
    $employeeAddress = $conn->real_escape_string($_POST['employeeAddress']);
    $employeeContact = $conn->real_escape_string($_POST['employeeContact']);

    $role = $_POST['role'];
    $userid = $_POST['userid'];

    $hashedEmployeePassword = md5($employeePassword);

    // Handle image upload
    $targetDir = "../uploads/"; // Define the target directory to save uploaded images
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);
    move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile);
    $fileName = basename($_FILES["file"]["name"]);

    // Split the full name into parts using a space as the delimiter
    $nameParts = explode(' ', $employeeName);

    // Get the first part (the first name)
    $username = $nameParts[0];

    $sql = "INSERT INTO users (userid, username, accpassword, fullname, email, contactnum, accrole, `address`, userimg) 
    VALUES ('$randomString', '$username', '$employeePassword', '$employeeName', '$employeeEmail', '$employeeContact', '$employeeRole', '$employeeAddress', '$fileName')";

    $auditSql = "INSERT INTO `audit` (`role`, userid, `date`, `time`, fromdev, `action`, prodname, info)
    VALUES ('$role', '$userid', '$currentDate', '$currentTime', '$device', 'Create Profile ', '$randomString', 'User')";

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