<?php
$conn = mysqli_connect("localhost", "root", "", "demopos");

if ($conn) {
    $prodid = $conn->real_escape_string($_POST['prodid']);

    $sql = "DELETE FROM products WHERE prodid = '$prodid'";
    $sqll = "DELETE FROM productmaterials WHERE prodid = '$prodid'";
    
    if ($conn->query($sql) === TRUE && $conn->query($sqll) === TRUE) {
        $response = array('success' => true);
        echo json_encode($response);
    } else {
        $response = array('success' => false, 'error' => $conn->error);
        echo json_encode($response);
    }

    $conn->close();
} else {
    $response = array('success' => false, 'error' => 'Database connection failed.');
    echo json_encode($response);
}
?>
