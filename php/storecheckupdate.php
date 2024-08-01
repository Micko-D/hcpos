<?php

// Create connection
$conn = mysqli_connect("localhost","root","","demopos");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$action = $_POST['action'];

// Fetch data from the database
$sql = "UPDATE `storecheck` SET `activity`='$action' WHERE id = $id";

if ($conn->query($sql)) {
    echo "Store updated successfully";
    // After successful insertion, return a JSON response
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$response = array('success' => true);
echo json_encode($response);
?>
