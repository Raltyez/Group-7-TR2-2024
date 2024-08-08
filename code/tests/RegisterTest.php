<?php
use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
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
    }

    public function testRegisterSuccess()
    {
        // Ensure no previous session is active
        session_unset();
        session_destroy();
        $_SESSION = [];

        // Set environment variable for testing
        putenv('APP_ENV=testing');

        // Simulate a POST request
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST["email"] = "newuser@example.com";
        $_POST["username"] = "newuser";
        $_POST["password"] = 'newpassword';
        $_POST["confirm_password"] = 'newpassword';

        ob_start();
        include dirname(__DIR__) . "/register.php";
        $output = ob_get_clean();

        echo "Output for testRegisterSuccess: $output\n"; // Debug output to see what's happening

        $this->assertStringContainsString("Registration Success", $output);

        // Verify that the user was inserted into the database
        $result = $this->connection->query("SELECT * FROM registration WHERE email = 'newuser@example.com'");
        $this->assertEquals(1, $result->num_rows, "User not inserted into the database");
    }

    public function testRegisterEmailExists()
    {
        // Insert a user to create a conflict
        $hashed_password = hash('sha256', 'password');
        $this->connection->query("INSERT INTO registration (email, username, password) VALUES ('existinguser@example.com', 'existinguser', '$hashed_password')");

        // Ensure no previous session is active
        session_unset();
        session_destroy();
        $_SESSION = [];

        // Set environment variable for testing
        putenv('APP_ENV=testing');

        // Simulate a POST request
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST["email"] = "existinguser@example.com";
        $_POST["username"] = "newuser";
        $_POST["password"] = 'newpassword';
        $_POST["confirm_password"] = 'newpassword';

        ob_start();
        include dirname(__DIR__) . "/register.php";
        $output = ob_get_clean();

        echo "Output for testRegisterEmailExists: $output\n"; // Debug output to see what's happening

        $this->assertStringContainsString("Email already exists. Please use a different email.", $output);
    }

    public function testRegisterPasswordMismatch()
    {
        // Ensure no previous session is active
        session_unset();
        session_destroy();
        $_SESSION = [];

        // Set environment variable for testing
        putenv('APP_ENV=testing');

        // Simulate a POST request
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST["email"] = "mismatchuser@example.com";
        $_POST["username"] = "mismatchuser";
        $_POST["password"] = 'password1';
        $_POST["confirm_password"] = 'password2';

        ob_start();
        include dirname(__DIR__) . "/register.php";
        $output = ob_get_clean();

        echo "Output for testRegisterPasswordMismatch: $output\n"; // Debug output to see what's happening

        $this->assertStringContainsString("Password and confirm password do not match.", $output);
    }

    protected function tearDown(): void
    {
        // Drop the test table after the tests run
        $this->connection->query("DROP TABLE IF EXISTS registration");

        // Close the connection
        $this->connection->close();
        echo "Test table 'registration' dropped and connection closed.\n";
    }
}
// ./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/RegisterTest.php   use this to run code
?>
