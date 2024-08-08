<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_password = $_POST["new_password"];
        $confirm_new_password = $_POST["confirm_new_password"];
        $email = $_SESSION['reset_email'];

        if ($new_password !== $confirm_new_password) {
            die("Password and confirm password do not match.");
        }

        // Hash the new password using SHA-256
        $hashed_password = hash('sha256', $new_password);

        // Database connection
        $connection = new mysqli("localhost", "root", "", "users");

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        } else {
            // Update the password in the database
            $statement = $connection->prepare("UPDATE registration SET password = ?, confirmation_code = NULL WHERE email = ?");
            $statement->bind_param("ss", $hashed_password, $email);

            if ($statement->execute()) {
                echo "Password has been reset successfully.";
            } else {
                echo "Failed to reset password. Please try again.";
            }

            $statement->close();
            $connection->close();
        }
    } else {
        echo "Invalid request method.";
    }
?>
