<?php
// Connect to the database (replace with your database connection code)
$conn = mysqli_connect("localhost","root","","demopos");
if ($conn) {
    $categoryId = $_POST['categoryId'];
    $isChecked = filter_var($_POST['isChecked'], FILTER_VALIDATE_BOOLEAN);

    // Determine the status based on the isChecked value
    $status = $isChecked ? "Enabled" : "Disabled";

    echo $status;
    // Update the status in the database
    $sql = "UPDATE categorylist SET `categorystatus` = '$status' WHERE id = $categoryId";

    if ($conn->query($sql) === TRUE) {
        echo "Category status updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "ERROR: Database is not connected...";
}
?>
