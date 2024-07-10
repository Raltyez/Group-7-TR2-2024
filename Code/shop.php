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
            echo '<div class="product" data-name="p-' . $row["product_id"] . '">
                    <img src="' . $row["product_image_url"] . '">
                    <h3>' . $row["product_name"] . '</h3>
                    <div class="price">$' . $row["product_price"] . '</div>
                  </div>';
        }

        echo '      </div>
                </div>
                <div class="products-preview">
                    <!-- Preview content here -->
                </div>
            </main>';
    } else {
        echo "No products found.";
    }
    // Close connection
    $conn->close();
?>

<script>
    let preveiwContainer = document.querySelector('.products-preview');
    let previewBox = preveiwContainer.querySelectorAll('.preview');
    document.querySelectorAll('.products-container .product').forEach(product =>{
    product.onclick = () =>{
        preveiwContainer.style.display = 'flex';
        let name = product.getAttribute('data-name');
        previewBox.forEach(preview =>{
        let target = preview.getAttribute('data-target');
        if(name == target){
            preview.classList.add('active');
        }
        });
    };
    });
    previewBox.forEach(close =>{
    close.querySelector('.fa-times').onclick = () =>{
        close.classList.remove('active');
        preveiwContainer.style.display = 'none';
    };
    });
</script>
