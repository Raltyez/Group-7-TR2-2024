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

    // Fetch products from the product table
    $sql = "SELECT * FROM product";
    $result = $conn->query($sql);

    // Display products
    if ($result->num_rows > 0) {
        echo '<main>
                <div class="container">
                    <h3 class="title">Shirts</h3>
                    <div class="products-container">';
        
        // Loop through each product row
        while($row = $result->fetch_assoc()) {
            echo '<div class="product" data-id="' . htmlspecialchars($row["product_id"]) . '" data-name="p-' . htmlspecialchars($row["product_id"]) . '">
                    <img src="' . htmlspecialchars($row["product_image_url"]) . '" alt="' . htmlspecialchars($row["product_name"]) . '">
                    <h3>' . htmlspecialchars($row["product_name"]) . '</h3>
                    <div class="price">$' . htmlspecialchars($row["product_price"]) . '</div>
                    <button class="cart">Add to Cart</button>
                  </div>';
        }

        echo '      </div>
                </div>
                <div class="products-preview">';
        
        // Loop through each product row again to create the previews
        $result->data_seek(0); // Reset result pointer to the beginning
        while($row = $result->fetch_assoc()) {
            echo '<div class="preview" data-target="p-' . htmlspecialchars($row["product_id"]) . '">
                        <i class="fa fa-times"></i>
                        <img src="' . htmlspecialchars($row["product_image_url"]) . '" alt="' . htmlspecialchars($row["product_name"]) . '">
                        <h3>' . htmlspecialchars($row["product_name"]) . '</h3>
                        <div class="price">$' . htmlspecialchars($row["product_price"]) . '</div>
                        <div class="buttons">
                            <button class="cart">Add to Cart</button>
                            <button class="buy">Buy Now</button>
                        </div>
                    </div>';
        }

        echo '      </div>
            </main>';
    } else {
        echo "<p>No products found.</p>";
    }

    // Close connection
    $conn->close();
?>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        let previewContainer = document.querySelector('.products-preview');
        let previewBoxes = previewContainer.querySelectorAll('.preview');
        document.querySelectorAll('.products-container .product').forEach(product => {
            product.onclick = () => {
                previewContainer.style.display = 'flex';
                let name = product.getAttribute('data-name');
                previewBoxes.forEach(preview => {
                    let target = preview.getAttribute('data-target');
                    if (name === target) {
                        preview.classList.add('active');
                    } else {
                        preview.classList.remove('active');
                    }
                });
            };
        });
        previewBoxes.forEach(preview => {
            preview.querySelector('.fa-times').onclick = () => {
                preview.classList.remove('active');
                previewContainer.style.display = 'none';
            };
        });

        // Add to Cart functionality
        document.querySelectorAll('.products-container .product .cart').forEach(button => {
            button.addEventListener('click', function (event) {
                event.stopPropagation(); // Prevent preview from opening
                let productId = button.closest('.product').getAttribute('data-id');
                let userId = <?= json_encode($user_id); ?>; // Get the user ID from PHP

                fetch('add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `user_id=${userId}&product_id=${productId}`
                })
                .then(response => response.text())
                .then(data => {
                    alert(data); // Display the response message
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });

        document.querySelectorAll('.products-preview .preview .cart').forEach(button => {
            button.addEventListener('click', function (event) {
                event.stopPropagation(); // Prevent preview from closing
                let productId = button.closest('.preview').getAttribute('data-target').substring(2);
                let userId = <?= json_encode($user_id); ?>; // Get the user ID from PHP

                fetch('add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `user_id=${userId}&product_id=${productId}`
                })
                .then(response => response.text())
                .then(data => {
                    alert(data); // Display the response message
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
