<?php

$servername = "localhost";
$username = "dev";
$password = "dev";
$database = "ecommerce";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($conn === null) {
    die("Database connection is null");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Prepare and execute the SQL query to clear the cart
    $stmt = $conn->prepare("DELETE FROM cart_items");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $response = array("success" => true, "message" => "Cart cleared successfully");
    } else {
        $response = array("success" => false, "message" => "Error clearing cart");
    }
    $stmt->close();
    echo json_encode($response);
}

$conn->close();
?>
