<?php
    include_once("header.php");

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page if not logged in
        header("Location: login.php");
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

    // Fetch cart items for the user using the corrected column name 'product_price'
    $sql = "SELECT ci.cart_item_id, p.product_name, p.product_image_url, p.product_price as price, ci.quantity
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
    echo '<style>
        .main-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            color: black;
            padding: 20px;
        }
        .cart-items {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            grid-gap: 20px;
            flex: 3;
        }
        .cart-item {
            display: flex;
            background: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .cart-item img {
            max-width: 50%;
            height: auto;
            display: block;
            margin-right: 20px;
        }
        .cart-item-details {
            flex: 1;
        }
        .total-price {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: linear-gradient(135deg, #f9f9f9, #e0e0e0);
            border: 1px solid #ddd;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin: 50px;
            border-radius: 10px;
        }
        .total-price h3 {
            margin: 0 0 10px 0;
            font-size: 32px;
        }
        .total-price p {
            font-size: 20px;
            font-weight: bold;
        }
        .cart-header {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            margin: 20px 0;
        }
        .cart-header h2 {
            font-size: 32px;
            color: white;
        }
        .cart-header {
            margin: 50px 20px 0 0;
            padding-left: 20px;
        }
      </style>';

    echo '<main>
            <div class="cart-header">
                <h2>Your Cart</h2>
            </div>
            <div class="main-container">
                <div class="cart-items">';
        
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="cart-item">
                    <img src="' . htmlspecialchars($row["product_image_url"]) . '" alt="' . htmlspecialchars($row["product_name"]) . '">
                    <div class="cart-item-details">
                        <h4>' . htmlspecialchars($row["product_name"]) . '</h4>
                        <p>Quantity: ' . htmlspecialchars($row["quantity"]) . '</p>
                        <p>Price: $' . number_format($row["price"], 2) . '</p>
                        <p>Total: $' . number_format($row["quantity"] * $row["price"], 2) . '</p>
                    </div>
                </div>';
        }
    } else {
        echo '<p id="empty_cart">Your cart is empty.</p>';
    }

    echo '    </div>
                <div class="total-price">
                    <h3>Total Price</h3>
                    <p>$' . number_format($total_price, 2) . '</p>
                </div>
            </div>
        </main>';


    // Close statement and connection
    $stmt->close();
    $conn->close();
?>
