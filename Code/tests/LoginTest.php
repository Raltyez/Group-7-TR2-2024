<?php
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
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

        // Drop the existing table if it exists
        $this->connection->query("DROP TABLE IF EXISTS registration");

        // Create a test table for registration
        $this->connection->query("CREATE TABLE registration (
            user_id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            username VARCHAR(255) NOT NULL,
            password VARCHAR(64) NOT NULL
        )");

        // Insert a test user
        $hashed_password = hash('sha256', 'test');
        $this->connection->query("INSERT INTO registration (email, username, password) VALUES ('test@example.com', 'testuser', '$hashed_password')");

        // Verify insertion
        $result = $this->connection->query("SELECT * FROM registration WHERE email = 'test@example.com'");
        $this->assertEquals(1, $result->num_rows, "Test user not inserted into the database");
    }

    public function testLoginSuccess()
    {
        // Ensure no previous session is active
        session_unset();
        session_destroy();
        $_SESSION = [];

        // Set environment variable for testing
        putenv('APP_ENV=testing');

        // Simulate a POST request
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST["email"] = "test@example.com";
        $_POST["password"] = 'test';

        ob_start();
        include dirname(__DIR__) . "/login.php";
        $output = ob_get_clean();

        echo "Output for testLoginSuccess: $output\n"; // Debug output to see what's happening

        $this->assertStringNotContainsString("User not found.", $output);
        $this->assertStringNotContainsString("Incorrect password.", $output);

        // Verify session variables
        $this->assertEquals('testuser', $_SESSION['username']);
        $this->assertEquals('test@example.com', $_SESSION['email']);
    }

    public function testLoginIncorrectPassword()
    {
        // Ensure no previous session is active
        session_unset();
        session_destroy();
        $_SESSION = [];

        // Set environment variable for testing
        putenv('APP_ENV=testing');

        // Simulate a POST request
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST["email"] = "test@example.com";
        $_POST["password"] = "wrongpassword";

        ob_start();
        include dirname(__DIR__) . "/login.php";
        $output = ob_get_clean();

        echo "Output for testLoginIncorrectPassword: $output\n"; // Debug output to see what's happening

        $this->assertStringContainsString("Incorrect password.", $output);
    }

    public function testLoginUserNotFound()
    {
        // Ensure no previous session is active
        session_unset();
        session_destroy();
        $_SESSION = [];

        // Set environment variable for testing
        putenv('APP_ENV=testing');

        // Simulate a POST request
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST["email"] = "nonexistent@example.com";
        $_POST["password"] = "password123";

        ob_start();
        include dirname(__DIR__) . "/login.php";
        $output = ob_get_clean();

        echo "Output for testLoginUserNotFound: $output\n"; // Debug output to see what's happening

        $this->assertStringContainsString("User not found.", $output);
    }

    protected function tearDown(): void
    {
        // Drop the test table after the tests run
        $this->connection->query("DROP TABLE IF EXISTS registration");

        // Close the connection
        $this->connection->close();
    }
}

// ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/LoginTest.php  use this to run code
?>