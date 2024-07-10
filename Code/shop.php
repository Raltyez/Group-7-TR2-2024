<?php
    include_once("header.php");

    // Database connection parameters
    $servername = "localhost";
    $username = "root";     // Your database username
    $password_db = "";      // Your database password (leave empty if no password)
    $dbname = "users";      // Your database name

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
                    <h3 class="title"> Shirts </h3>
                    <div class="products-container">';
        
        // Loop through each product row
        while($row = $result->fetch_assoc()) {
            echo '<div class="product" data-name="p-' . htmlspecialchars($row["product_id"]) . '">
                    <img src="' . htmlspecialchars($row["product_image_url"]) . '">
                    <h3>' . htmlspecialchars($row["product_name"]) . '</h3>
                    <div class="price">$' . htmlspecialchars($row["product_price"]) . '</div>
                  </div>';
        }

        echo '      </div>
                </div>
                <div class="products-preview">
                    <div class="preview" data-target="p-1">
                        <i class="fa fa-times"></i>
                        <img src="image_url_here" alt="product image">
                        <h3>Product Title</h3>
                        <p>Product description goes here.</p>
                        <div class="price">$Price</div>
                        <div class="buttons">
                            <a href="#" class="cart">Add to Cart</a>
                            <a href="#" class="buy">Buy Now</a>
                        </div>
                    </div>
                    <!-- More preview items here if needed -->
                </div>
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
    });
</script>
