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

    // Fetch products from the product table
    $sql = "SELECT * FROM product";
    $result = $conn->query($sql);
?>

<style>
    .products_preview {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        justify-content: center;
        align-items: center;
    }

    .preview {
        display: none;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        max-width: 500px;
        text-align: center;
    }

    .preview.active {
        display: block;
    }

    .preview img {
        max-width: 100%;
        height: auto;
        display: block;
        margin-bottom: 10px;
    }

    .preview h3 {
        margin: 10px 0;
        font-size: 18px;
    }

    .preview .price {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .product_options {
        display: flex;
        justify-content: space-around;
        margin-bottom: 20px;
    }

    .size_option, .color_option {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .size_option label, .color_option label {
        margin-bottom: 5px;
    }

    .preview .buttons {
        display: flex;
        justify-content: space-between;
    }

    .preview .cart, .preview .buy {
        background-color: orange;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        margin: 5px;
    }

    .preview .cart:hover, .preview .buy:hover {
        background-color: darkorange;
    }

    .preview .fa-times {
        position: absolute;
        top: 1rem;
        right: 1.5rem;
        cursor: pointer;
        color: white;
        font-size: 4rem;
        transition: transform 0.3s ease;
    }

    .preview .fa-times:hover {
        transform: rotate(90deg);
    }
</style>

<?php
    // Display products
    if ($result->num_rows > 0) {
        echo '<main>
                <div class="container">
                    <h3 class="title">Shirts</h3>
                    <div class="products_container">';
        
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
                <div class="products_preview">';
        
        // Loop through each product row again to create the previews
        $result->data_seek(0); // Reset result pointer to the beginning
        while($row = $result->fetch_assoc()) {
            echo '<div class="preview" data-target="p-' . htmlspecialchars($row["product_id"]) . '">
                        <i class="fa fa-times"></i>
                        <img src="' . htmlspecialchars($row["product_image_url"]) . '" alt="' . htmlspecialchars($row["product_name"]) . '" class="product_picture">
                        <h3>' . htmlspecialchars($row["product_name"]) . '</h3>
                        <div class="price">$' . htmlspecialchars($row["product_price"]) . '</div>
                        <div class="product_options">
                            <div class="size_option">
                                <label for="size">Size:</label>
                                <select class="size">
                                    <option value="small" selected>Small</option>
                                    <option value="medium">Medium</option>
                                    <option value="large">Large</option>
                                    <option value="xlarge">X-Large</option>
                                </select>
                            </div>
                            <div class="color_option">
                                <label for="color">Color:</label>
                                <select class="color">
                                    <option value="white" selected>White</option>
                                    <option value="black">Black</option>
                                    <option value="gray">Gray</option>
                                    <option value="blue">Blue</option>
                                </select>
                            </div>
                        </div>
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
        let previewContainer = document.querySelector('.products_preview');
        let previewBoxes = previewContainer.querySelectorAll('.preview');
        document.querySelectorAll('.products_container .product').forEach(product => {
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
        document.querySelectorAll('.products_container .product .cart').forEach(button => {
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

        document.querySelectorAll('.products_preview .preview .cart').forEach(button => {
            button.addEventListener('click', function (event) {
                event.stopPropagation(); // Prevent preview from closing
                let productId = button.closest('.preview').getAttribute('data-target').substring(2);
                let userId = <?= json_encode($user_id); ?>; // Get the user ID from PHP

                let size = button.closest('.preview').querySelector('.size').value;
                let color = button.closest('.preview').querySelector('.color').value;

                fetch('add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `user_id=${userId}&product_id=${productId}&size=${size}&color=${color}`
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

<?php 
    include_once("footer.html");
?>
