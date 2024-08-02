<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user_id = $_SESSION['user_id']; // Assuming the user is logged in and user_id is stored in session
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

    // Determine the database to use based on an environment variable
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = getenv('APP_ENV') === 'testing' ? 'tests' : 'users'; // Use 'tests' database in test environment

    // Create connection
    $connection = new mysqli($servername, $username, $password_db, $dbname);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    } else {
        // Insert data into the database
        $sql = "INSERT INTO payments (user_id, full_name, email, address, city, state, zip_code, card_name, card_number, exp_month, exp_year, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $statement = $connection->prepare($sql);
        $statement->bind_param("isssssssssis", $user_id, $full_name, $email, $address, $city, $state, $zip_code, $card_name, $card_number, $exp_month, $exp_year, $cvv);

        if ($statement->execute()) {
            echo "Payment processed successfully.";
        } else {
            echo "Error: " . $statement->error;
        }

        // Close statement and connection
        $statement->close();
        $connection->close();
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>
