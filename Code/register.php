<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize response array
    $response = array("status" => "", "message" => "");

    // Validate and sanitize input data
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Lower email
    $email = strtolower($email);

    // Check if password and confirm password match
    if ($password !== $confirm_password) {
        $response["status"] = "error";
        $response["message"] = "Password and confirm password do not match.";
        echo json_encode($response);
        exit;
    }

    // Hash the password using SHA-256
    $hashed_password = hash('sha256', $password);

    // Database Connection ("localhost", "username", "password (default xampp blank)", "database name")
    $dbname = getenv('APP_ENV') === 'testing' ? 'tests' : 'users';
    $connection = new mysqli("localhost", "root", "", $dbname);

    if ($connection->connect_error) {
        $response["status"] = "error";
        $response["message"] = "Connection Failed: " . $connection->connect_error;
        echo json_encode($response);
        exit;
    } else {
        // Check if the email already exists in the database (prepared statement)
        $check_statement = $connection->prepare("SELECT user_id FROM registration WHERE email = ?");
        $check_statement->bind_param("s", $email);
        $check_statement->execute();
        $check_result = $check_statement->get_result();

        if ($check_result->num_rows > 0) {
            // Email already exists
            $response["status"] = "error";
            $response["message"] = "Email already exists. Please use a different email.";
        } else {
            // Proceed with registration (prepared statement)
            $statement = $connection->prepare("INSERT INTO registration (email, username, password) VALUES (?, ?, ?)");
            $statement->bind_param("sss", $email, $username, $hashed_password);

            if ($statement->execute()) {
                // Registration successful, set session variables
                $_SESSION['user_id'] = $statement->insert_id;
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $username;
                $_SESSION['logged_in'] = true;

                $response["status"] = "success";
                $response["message"] = "Registration Success";
            } else {
                $response["status"] = "error";
                $response["message"] = "Registration Failed: " . $statement->error;
            }

            $statement->close();
        }

        $check_statement->close();
        $connection->close();
    }

    echo json_encode($response);
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method."));
}
?>
