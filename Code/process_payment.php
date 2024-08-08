<?php
include_once("header.php");

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

// Simulate payment success
$payment_success = true;

if ($payment_success) {
    // Collect payment details
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip_code = $_POST['zip_code'];
    $card_name = $_POST['card_name'];
    $card_number = $_POST['card_number'];
    $exp_month = $_POST['exp_month'];
    $exp_year = $_POST['exp_year'];
    $cvv = $_POST['cvv'];

    // Fetch cart items for the user
    $sql = "SELECT ci.cart_item_id, ci.product_id, p.product_price as price, ci.quantity
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
    $cart_items = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $total_price += $row["price"] * $row["quantity"];
            $cart_items[] = $row;
        }
    }

    // Save order to the database
    $sql = "INSERT INTO orders (user_id, total_price) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $user_id, $total_price);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Save order items to the database
    foreach ($cart_items as $item) {
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiid", $order_id, $item["product_id"], $item["quantity"], $item["price"]);
        $stmt->execute();
        $stmt->close();
    }

    // Save payment details to the database
    $sql = "INSERT INTO payments (user_id, full_name, email, address, city, state, zip_code, card_name, card_number, exp_month, exp_year, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssssssssis", $user_id, $full_name, $email, $address, $city, $state, $zip_code, $card_name, $card_number, $exp_month, $exp_year, $cvv);
    $stmt->execute();
    $stmt->close();

    // Clear the cart
    $sql = "DELETE ci
            FROM cart_items ci
            JOIN cart c ON ci.cart_id = c.cart_id
            WHERE c.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    $message = "Payment successful. Your order has been placed.";
} else {
    $message = "Payment failed. Please try again.";
}

$conn->close();
?>

<style>
.process_payment_message {
    color: white;
    text-align: center;
    font-size: 32px;
    margin: 0 auto;
    padding: 3rem 2rem;
}
</style>

<main>
    <div class="process_payment_message">
        <?php echo $message; ?>
    </div>
</main>
</body>
</html>

<?php 
include_once("footer.html");
?>
