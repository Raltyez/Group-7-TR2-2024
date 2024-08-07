<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Lower email
    $email = strtolower($email);

    // Hash the entered password using SHA-256
    $hashed_password = hash('sha256', $password);

    // Determine the database to use based on an environment variable
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = getenv('APP_ENV') === 'testing' ? 'tests' : 'users'; // Use 'tests' database in test environment

    // Create connection
    $connection = new mysqli($servername, $username, $password_db, $dbname);

    // Check connection
    if ($connection->connect_error) {
        $response = array("status" => "error", "message" => "Connection failed: " . $connection->connect_error);
        echo json_encode($response);
        exit();
    } else {
        // Prepare SQL statement to retrieve user data
        $statement = $connection->prepare("SELECT user_id, username, email, password FROM registration WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows == 1) {
            // User found, verify password
            $row = $result->fetch_assoc();
            $stored_hashed_password = $row['password'];

            // Compare the hashed passwords
            if ($hashed_password === $stored_hashed_password) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['logged_in'] = true;

                // Return success response
                $response = array("status" => "success", "message" => "Login successful");
                echo json_encode($response);
                exit();
            } else {
                // Incorrect password
                $response = array("status" => "error", "message" => "Incorrect password.");
                echo json_encode($response);
                exit();
            }
        } else {
            // User not found
            $response = array("status" => "error", "message" => "User not found.");
            echo json_encode($response);
            exit();
        }

        // Close statement and connection
        $statement->close();
        $connection->close();
    }
} else {
    // Invalid request method
    $response = array("status" => "error", "message" => "Invalid request method.");
    echo json_encode($response);
    exit();
}
?>
