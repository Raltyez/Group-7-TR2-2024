<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $confirmation_code = $_POST["confirmation_code"];

        // Database connection
        $connection = new mysqli("localhost", "root", "", "users");

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        } else {
            // Verify the confirmation code
            $statement = $connection->prepare("SELECT user_id, email FROM registration WHERE confirmation_code = ?");
            $statement->bind_param("s", $confirmation_code);
            $statement->execute();
            $result = $statement->get_result();

            if ($result->num_rows == 1) {
                // Code is correct, proceed with password reset
                $row = $result->fetch_assoc();
                $_SESSION['reset_email'] = $row['email'];

                header("Location: reset_password_form.php");
                exit();
            } else {
                echo "Invalid confirmation code.";
            }

            $statement->close();
            $connection->close();
        }
    } else {
        echo "Invalid request method.";
    }
?>
