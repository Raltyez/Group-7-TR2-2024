<?php
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

    // Get POST data
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];

    // Check if the user already has a cart
    $sql = "SELECT cart_id FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Create a new cart for the user if it doesn't exist
        $sql = "INSERT INTO cart (user_id) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $cart_id = $stmt->insert_id;
    } else {
        // Get the existing cart ID
        $row = $result->fetch_assoc();
        $cart_id = $row['cart_id'];
    }

    // Check if the product is already in the cart
    $sql = "SELECT quantity FROM cart_items WHERE cart_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cart_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Add the product to the cart if it doesn't exist
        $sql = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $cart_id, $product_id);
        $stmt->execute();
    } else {
        // Update the quantity if the product is already in the cart
        $row = $result->fetch_assoc();
        $quantity = $row['quantity'] + 1;
        $sql = "UPDATE cart_items SET quantity = ? WHERE cart_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $quantity, $cart_id, $product_id);
        $stmt->execute();
    }

    echo "Product added to cart successfully.";

    // Close connection
    $conn->close();
?>
