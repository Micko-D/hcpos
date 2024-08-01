<?php

// Create connection
$conn = mysqli_connect("localhost", "root", "", "demopos");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['drink'])) {
    $selectedDrink = $_GET['drink'];

    // Fetch cup sizes for the selected drink from the database
    $sql = "SELECT * FROM cup_sizes WHERE drink_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedDrink);
    $stmt->execute();
    $result = $stmt->get_result();

    $cupSizes = array();
    while ($row = $result->fetch_assoc()) {
        $cupSize = array(
            "name" => $row["cup_size_name"],
            "img" => $row["cup_size_img"],
            "price" => $row["cup_size_price"]
        );
        $cupSizes[] = $cupSize;
    }

    // Return cup sizes as JSON response
    header("Content-Type: application/json");
    echo json_encode($cupSizes);
} else {
    // Fetch data from the database
    $sql = "SELECT * FROM products WHERE producttype = 'Drink'"; // Replace with your table name
    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Return data as JSON response
    header("Content-Type: application/json");
    echo json_encode($data);
}

$conn->close();
?>
