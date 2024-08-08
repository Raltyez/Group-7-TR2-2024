<?php
include_once("header.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: sign_in_page.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

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

// Handle quantity update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && isset($_POST['cart_item_id'])) {
    $cart_item_id = $_POST['cart_item_id'];
    $action = $_POST['action'];

    if ($action == 'increase') {
        $sql = "UPDATE cart_items SET quantity = quantity + 1 WHERE cart_item_id = ?";
    } elseif ($action == 'decrease') {
        $sql = "UPDATE cart_items SET quantity = quantity - 1 WHERE cart_item_id = ? AND quantity > 0";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cart_item_id);
    $stmt->execute();
    $stmt->close();

    // Remove item if quantity is zero
    $sql = "DELETE FROM cart_items WHERE quantity = 0";
    $conn->query($sql);
}

// Fetch cart items for the user
$sql = "SELECT ci.cart_item_id, p.product_name, p.product_image_url, p.product_price as price, ci.quantity, ci.size, ci.color
        FROM cart_items ci
        JOIN cart c ON ci.cart_id = c.cart_id
        JOIN product p ON ci.product_id = p.product_id
        WHERE c.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Calculate total price
$total_price = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total_price += $row["price"] * $row["quantity"];
    }
    $result->data_seek(0); // Reset the result set pointer
}

// Display cart items
echo '<main>
        <div class="cart_header">
            <h2>Your Cart</h2>
        </div>
        <div class="main_container">';
        
if ($result->num_rows > 0) {
    echo '<div class="cart_items">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="cart_item">
                <img src="' . htmlspecialchars($row["product_image_url"]) . '" alt="' . htmlspecialchars($row["product_name"]) . '">
                <div class="cart_item_details">
                    <h4>' . htmlspecialchars($row["product_name"]) . '</h4>
                    <p>Size: ' . htmlspecialchars($row["size"]) . '</p>
                    <p>Color: ' . htmlspecialchars($row["color"]) . '</p>
                    <p>Quantity: ' . htmlspecialchars($row["quantity"]) . '</p>
                    <p>Price: $' . number_format($row["price"], 2) . '</p>
                    <p>Total: $' . number_format($row["quantity"] * $row["price"], 2) . '</p>
                    <div class="quantity_controls">
                        <form method="post">
                            <input type="hidden" name="cart_item_id" value="' . $row["cart_item_id"] . '">
                            <input type="hidden" name="action" value="decrease">
                            <button type="submit">-</button>
                        </form>
                        <span>' . htmlspecialchars($row["quantity"]) . '</span>
                        <form method="post">
                            <input type="hidden" name="cart_item_id" value="' . $row["cart_item_id"] . '">
                            <input type="hidden" name="action" value="increase">
                            <button type="submit">+</button>
                        </form>
                    </div>
                </div>
            </div>';
    }
    echo '</div>';
} else {
    echo '<div class="empty_cart">
            <p>Your cart is empty.</p>
            <a href="shop.php">Continue Shopping</a>
          </div>';
}

echo '    <div class="total_price">
                <h3>Total Price</h3>
                <p>$' . number_format($total_price, 2) . '</p>
                <a href="payment_page.php" class="checkout_btn">Proceed to Payment</a>
            </div>
        </div>
    </main>';

// Close statement and connection
$stmt->close();
$conn->close();
?>

<?php 
    include_once("footer.html");
?>