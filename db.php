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
    category ENUM('men', 'women', 'children') NOT NULL,
    subcategory ENUM('Jackets', 'Sweaters', 'Bottoms', 'Dresses', 'Accessories', 'Tops', 'Skirts', 'Shorts', 'Swimwear', 'Pants') NOT NULL,
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
    ['Combo', 'men', 'Jackets', 25, 'Black', 120.00, 'images/combo.jpg'],
    ['Dress', 'men', 'Jackets', 15, 'Brown', 150.00, 'images/dress.jpg'],
    ['Gown', 'women', 'Sweaters', 30, 'Red', 45.00, 'images/gown.jpg'],
    ['Green Dress', 'women', 'Dresses', 20, 'Blue', 80.00, 'images/greenDress.jpg'],
    ['Gym Wear', 'men', 'Accessories', 50, 'Black', 200.00, 'images/gymWear.jpg'],
    ['One Piece', 'women', 'Bottoms', 40, 'White', 90.00, 'images/onePiece.jpg'],
    ['Pink Dress', 'women', 'Skirts', 34, 'Blue', 35.00, 'images/pinkDress.jpg'],
    ['Shirt', 'men', 'Shorts', 22, 'Green', 29.99, 'images/shirt.jpg'],
    ['Shirts', 'women', 'Swimwear', 19, 'Pink', 25.00, 'images/shirts.jpg'],
    ['Shoes', 'men', 'Pants', 18, 'Grey', 45.00, 'images/shoes.jpg'],
    ['Sweater', 'children', 'Accessories', 50, 'Purple', 30.00, 'images/sweater.jpg'],
    ['T-Shirt', 'children', 'Accessories', 30, 'Yellow', 15.00, 'images/tShirt.jpg']
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