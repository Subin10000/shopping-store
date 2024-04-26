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
    category ENUM('Root', 'Fruit', 'Allium', 'Spice', 'Pod', 'Vegetable', 'Nightshade', 'Gourd', 'Legume', 'Squash') NOT NULL,
    subcategory ENUM('Vegetable', 'Nightshade', 'Bulb', 'Spice', 'Legume', 'Gourd', 'Squash') NOT NULL,
    quantity INT(6) NOT NULL,
    color VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    count INT(5) NOT NULL,
    image VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'products' updated successfully<br>";
} else {
    echo "Error updating table: " . $conn->error;
}

$sql = "CREATE TABLE IF NOT EXISTS cart_items (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    quantity INT(6) NOT NULL,
    price DECIMAL(10,2) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'cart_items' updated successfully<br>";
} else {
    echo "Error updating table: " . $conn->error;
}


$products = [
    ['Potato', 'Root', 'Vegetable', 100, 'Brown', 2.50, 5, 'images/potato.jpg'],
    ['Tomato', 'Fruit', 'Nightshade', 15, 'Red', 150.00, 3, 'images/tomato.jpg'],
    ['Pumpkin', 'Fruit', 'Squash', 30, 'Orange', 45.00, 7, 'images/pumpkin.jpg'],
    ['Garlic', 'Allium', 'Bulb', 60, 'White', 0.50, 2, 'images/garlic.jpg'],
    ['Ginger', 'Spice', 'Spice', 50, 'Beige', 200.00, 4, 'images/ginger.jpg'],
    ['Carrot', 'Root', 'Vegetable', 150, 'Orange', 3.00, 6, 'images/carrots.jpg'],
    ['Okra', 'Pod', 'Vegetable', 34, 'Green', 35.00, 8, 'images/okra.jpg'],
    ['Capsicum', 'Fruit', 'Nightshade', 22, 'Green', 29.99, 9, 'images/capsicum.jpg'],
    ['Cucumber', 'Fruit', 'Gourd', 75, 'Green', 1.20, 1, 'images/cucumber.jpg'],
    ['Beans', 'Pod', 'Legume', 18, 'Green', 45.00, 10, 'images/beans.jpg'],
    ['Zucchini', 'Fruit', 'Squash', 85, 'Green', 0.95, 12, 'images/zucchini.jpg'],
    ['Onion', 'Allium', 'Bulb', 110, 'Yellow', 0.30, 11, 'images/onion.jpg']
];

try {
    foreach ($products as $product) {
        $sql = $conn->prepare("INSERT INTO products (name, category, subcategory, quantity, color, price, count, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param("sssisdss", $product[0], $product[1], $product[2], $product[3], $product[4], $product[5], $product[6], $product[7]);
        $sql->execute();
    }
    echo "Products inserted successfully.<br>";
} catch (mysqli_sql_exception $e) {
    echo "Error inserting product: " . $e->getMessage() . "<br>";
}


$conn->close();
