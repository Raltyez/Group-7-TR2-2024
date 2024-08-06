<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "users";

// Create connection
$conn = new mysqli($servername, $username, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST parameters
$user_id = $_POST['user_id'];
$product_id = $_POST['product_id'];
$size = isset($_POST['size']) ? $_POST['size'] : 'small'; // Default size: small
$color = isset($_POST['color']) ? $_POST['color'] : 'white'; // Default color: white

// Get the user's cart ID
$sql = "SELECT cart_id FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User has a cart, get the cart ID
    $row = $result->fetch_assoc();
    $cart_id = $row['cart_id'];
} else {
    // User does not have a cart, create a new one
    $sql = "INSERT INTO cart (user_id) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_id = $stmt->insert_id;
}

// Check if the product is already in the cart with the same size and color
$sql = "SELECT cart_item_id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ? AND size = ? AND color = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $cart_id, $product_id, $size, $color);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Product is already in the cart, update the quantity
    $row = $result->fetch_assoc();
    $cart_item_id = $row['cart_item_id'];
    $quantity = $row['quantity'] + 1;

    $sql = "UPDATE cart_items SET quantity = ? WHERE cart_item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $quantity, $cart_item_id);
    $stmt->execute();
} else {
    // Product is not in the cart, add it
    $sql = "INSERT INTO cart_items (cart_id, product_id, quantity, size, color) VALUES (?, ?, 1, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $cart_id, $product_id, $size, $color);
    $stmt->execute();
}

echo "Item added to cart";

// Close connection
$conn->close();
?>
