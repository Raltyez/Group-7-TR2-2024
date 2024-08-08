<?php
use PHPUnit\Framework\TestCase;

class AddToCartTest extends TestCase
{
    private $connection;

    protected function setUp(): void
    {
        // Set up a test database connection
        $servername = "localhost";
        $username = "root";
        $password_db = "";
        $dbname = "tests";

        // Create connection
        $this->connection = new mysqli($servername, $username, $password_db, $dbname);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }

        // Drop existing tables if they exist
        $this->connection->query("DROP TABLE IF EXISTS cart_items");
        $this->connection->query("DROP TABLE IF EXISTS cart");
        $this->connection->query("DROP TABLE IF EXISTS users");
        $this->connection->query("DROP TABLE IF EXISTS products");

        // Create tables for testing
        $this->connection->query("CREATE TABLE users (user_id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) NOT NULL)");
        $this->connection->query("CREATE TABLE products (product_id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL)");
        $this->connection->query("CREATE TABLE cart (cart_id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL)");
        $this->connection->query("CREATE TABLE cart_items (cart_item_id INT AUTO_INCREMENT PRIMARY KEY, cart_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL)");

        // Insert test data
        $this->connection->query("INSERT INTO users (email) VALUES ('testuser@example.com')");
        $this->connection->query("INSERT INTO products (name) VALUES ('Test Product')");
    }

    public function testAddToCartNewProduct()
    {
        // Ensure no previous session is active
        session_unset();
        session_destroy();
        $_SESSION = [];

        // Set environment variable for testing
        putenv('APP_ENV=testing');

        // Simulate a POST request
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['user_id'] = 1;
        $_POST['product_id'] = 1;

        ob_start();
        include dirname(__DIR__) . "/add_to_cart.php";
        $output = ob_get_clean();

        echo "Output for testAddToCartNewProduct: $output\n"; // Debug output to see what's happening

        $this->assertStringContainsString("Product added to cart successfully.", $output);

        // Verify that the product was added to the cart
        $result = $this->connection->query("SELECT * FROM cart_items WHERE cart_id = 1 AND product_id = 1");
        $this->assertEquals(1, $result->num_rows, "Product not added to the cart");
        $row = $result->fetch_assoc();
        $this->assertEquals(1, $row['quantity'], "Quantity is not correct");
    }

    public function testAddToCartExistingProduct()
    {
        // Insert a cart and cart item for the user
        $this->connection->query("INSERT INTO cart (user_id) VALUES (1)");
        $this->connection->query("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (1, 1, 1)");

        // Ensure no previous session is active
        session_unset();
        session_destroy();
        $_SESSION = [];

        // Set environment variable for testing
        putenv('APP_ENV=testing');

        // Simulate a POST request
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['user_id'] = 1;
        $_POST['product_id'] = 1;

        ob_start();
        include dirname(__DIR__) . "/add_to_cart.php";
        $output = ob_get_clean();

        echo "Output for testAddToCartExistingProduct: $output\n"; // Debug output to see what's happening

        $this->assertStringContainsString("Product added to cart successfully.", $output);

        // Verify that the product quantity was updated in the cart
        $result = $this->connection->query("SELECT * FROM cart_items WHERE cart_id = 1 AND product_id = 1");
        $this->assertEquals(1, $result->num_rows, "Product not added to the cart");
        $row = $result->fetch_assoc();
        $this->assertEquals(2, $row['quantity'], "Quantity is not updated correctly");
    }

    protected function tearDown(): void
    {
        // Drop the test tables after the tests run
        $this->connection->query("DROP TABLE IF EXISTS cart_items");
        $this->connection->query("DROP TABLE IF EXISTS cart");
        $this->connection->query("DROP TABLE IF EXISTS users");
        $this->connection->query("DROP TABLE IF EXISTS products");

        // Close the connection
        $this->connection->close();
        echo "Test tables dropped and connection closed.\n";
    }
}
// ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/AddToCartTest.php   use this to run code
?>
