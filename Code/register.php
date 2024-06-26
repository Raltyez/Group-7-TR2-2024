<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize input data
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        $username = htmlspecialchars($_POST["username"]); // Example of basic sanitization
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        // Lower email
        $email = strtolower($email);

        // Check if password and confirm password match
        if ($password !== $confirm_password) {
            die("Password and confirm password do not match.");
        }

        // Hash the password using SHA-256
        $hashed_password = hash('sha256', $password);

        // Database Connection ("localhost", "username", "password (default xampp blank)", "database name")
        $connection = new mysqli("localhost", "root", "", "users");

        if ($connection->connect_error) {
            die("Connection Failed: " . $connection->connect_error);
        } else {
            // Check if the email already exists in the database (prepared statement)
            $check_statement = $connection->prepare("SELECT user_id FROM registration WHERE email = ?");
            $check_statement->bind_param("s", $email);
            $check_statement->execute();
            $check_result = $check_statement->get_result();

            if ($check_result->num_rows > 0) {
                // Email already exists
                echo "Email already exists. Please use a different email.";
            } else {
                // Proceed with registration (prepared statement)
                $statement = $connection->prepare("INSERT INTO registration (email, username, password) VALUES (?, ?, ?)");
                $statement->bind_param("sss", $email, $username, $hashed_password);

                if ($statement->execute()) {
                    echo "Registration Success";
                } else {
                    echo "Registration Failed: " . $statement->error;
                }

                $statement->close();
            }

            $check_statement->close();
            $connection->close();
        }
    } else {
        echo "Invalid request method.";
    }
?>
