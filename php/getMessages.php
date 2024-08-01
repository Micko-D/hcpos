<?php

// Create connection
$conn = mysqli_connect("localhost","root","","demopos");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$convoID = $_POST['convoID'];

// Fetch data from the database
$sql = "SELECT messages.*, users.fullname, users.userimg FROM messages JOIN users ON messages.userid=users.userid WHERE conversationid = '$convoID' ORDER BY datetimemess ASC"; // Replace with your table name
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

// Return data as JSON response
header("Content-Type: application/json");
echo json_encode($data);
?>
