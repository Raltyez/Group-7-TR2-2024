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

// Fetch order history for the user
$sql = "SELECT o.order_id, o.total_price, o.created_at, oi.product_id, oi.quantity, oi.price, p.product_name, p.product_image_url
        FROM orders o
        JOIN order_items oi ON o.order_id = oi.order_id
        JOIN product p ON oi.product_id = p.product_id
        WHERE o.user_id = ?
        ORDER BY o.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Display order history
if ($result->num_rows > 0) {
    echo '<main>
            <div class="container">
                <h3 class="order_title">Your Order History</h3>
                <div class="orders_container">';
    
    while ($row = $result->fetch_assoc()) {
        echo '<div class="order" data-id="' . htmlspecialchars($row["order_id"]) . '" data-name="o-' . htmlspecialchars($row["order_id"]) . '">
                <img src="' . htmlspecialchars($row["product_image_url"]) . '" alt="' . htmlspecialchars($row["product_name"]) . '">
                <h3>' . htmlspecialchars($row["product_name"]) . '</h3>
                <div class="order_details">
                    <p>Quantity: ' . htmlspecialchars($row["quantity"]) . '</p>
                    <p>Price: $' . number_format($row["price"], 2) . '</p>
                    <p>Order Total: $' . number_format($row["total_price"], 2) . '</p>
                    <p>Ordered On: ' . htmlspecialchars($row["created_at"]) . '</p>
                </div>
              </div>';
    }

    echo '      </div>
            </div>
        </main>';
} else {
    echo "<p>No orders found.</p>";
}

// Close connection
$stmt->close();
$conn->close();
?>

<?php 
    include_once("footer.html");
?>
