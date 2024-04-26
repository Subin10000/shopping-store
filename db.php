<?php
$servername = "localhost";
$username = "dev";
$password = "dev";
$database = "ecommerce";
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create or update the table schema to include a VARCHAR type for image paths
$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
   category ENUM('Root', 'Fruit', 'Allium', 'Spice', 'Pod', 'Fruit Vegetable', 'Nightshade', 'Gourd', 'Legume', 'Squash') NOT NULL,
    subcategory ENUM('Root Vegetable', 'Nightshade', 'Bulb', 'Root Spice', 'Fruit Vegetable', 'Legume', 'Gourd', 'Squash') NOT NULL,
    quantity INT(6) NOT NULL,
    color VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'products' updated successfully<br>";
} else {
    echo "Error updating table: " . $conn->error;
}


$products = [
    ['Potato', 'Root', 'Root Vegetable', 100, 'Brown', 2.50, 'images/potato.jpg'],
    ['Tomato', 'Fruit', 'Nightshade', 15, 'Red', 150.00, 'images/tomato.jpg'],
    ['Pumpkin', 'Fruit', 'Squash', 30, 'Orange', 45.00, 'images/pumpkin.jpg'],
    ['Garlic', 'Allium', 'Bulb', 60, 'White', 0.50, 'images/garlic.jpg'],
    ['Ginger', 'Spice', 'Root Spice', 50, 'Beige', 200.00, 'images/ginger.jpg'],
    ['Carrot', 'Root', 'Root Vegetable', 150, 'Orange', 3.00, 'images/carrots.jpg'],
    ['Okra', 'Pod', 'Fruit Vegetable', 34, 'Green', 35.00, 'images/okra.jpg'],
    ['Capsicum', 'Fruit', 'Nightshade', 22, 'Green', 29.99, 'images/capsicum.jpg'],
    ['Cucumber', 'Fruit', 'Gourd', 75, 'Green', 1.20, 'images/cucumber.jpg'],
    ['Beans', 'Pod', 'Legume', 18, 'Green', 45.00, 'images/beans.jpg'],
    ['Zucchini', 'Fruit', 'Squash', 85, 'Green', 0.95, 'images/zucchini.jpg'],
    ['Onion', 'Allium', 'Bulb', 110, 'Yellow', 0.30, 'images/onion.jpg']
];

foreach ($products as $product) {
    $sql = $conn->prepare("INSERT INTO products (name, category, subcategory, quantity, color, price, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("sssisds", $product[0], $product[1], $product[2], $product[3], $product[4], $product[5], $product[6]);
    if (!$sql->execute()) {
        echo "Error inserting product: " . $sql->error . "<br>";
    }
}

echo "Products inserted successfully.<br>";

$sql = "CREATE TABLE IF NOT EXISTS cart_items (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    unit INT(6) NOT NULL,
    price DECIMAL(10,2) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'cart_items' updated successfully<br>";
} else {
    echo "Error updating table: " . $conn->error;
}

$conn->close();
?>