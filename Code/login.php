<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Hash the entered password using SHA-256
        $hashed_password = hash('sha256', $password);

        // Database Connection
        $servername = "localhost";
        $username = "root";   // Your database username
        $password_db = "";    // Your database password (leave empty if no password)
        $dbname = "users";    // Your database name
        $connection = new mysqli($servername, $username, $password_db, $dbname);

        // Check connection
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        } else {
            // Prepare SQL statement to retrieve user data
            $statement = $connection->prepare("SELECT email, password FROM registration WHERE email = ?");
            $statement->bind_param("s", $email);
            $statement->execute();
            $result = $statement->get_result();

            if ($result->num_rows == 1) {
                // User found, verify password
                $row = $result->fetch_assoc();
                $stored_hashed_password = $row['password'];  // Correct

                // Compare the hashed passwords
                if ($hashed_password === $stored_hashed_password) {
                    // Password is correct, set session variables
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['logged_in'] = true;

                    // Redirect to dashboard or another secure page
                    header("Location: purple_star.jpg");
                    exit();
                } else {
                    // Incorrect password
                    echo "Incorrect password. Hashed password: " . $hashed_password;
                }
            } else {
                // User not found
                echo "User not found.";
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
