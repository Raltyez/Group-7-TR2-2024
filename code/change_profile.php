<?php
    session_start();
    if(!isset($_SESSION["user_id"])) {
        header("Location: sign_in_page.php");
        exit();
    }

    // Database Connection
    $servername = "localhost";
    $username = "root";   // Your database username
    $password_db = "";    // Your database password (leave empty if no password)
    $dbname = "users";    // Your database name
    $connection = new mysqli($servername, $username, $password_db, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_username = $_POST["username"];
        $new_address = $_POST["address"];

        // Update user information
        $update_statement = $connection->prepare("UPDATE registration SET username = ?, address = ? WHERE user_id = ?");
        $update_statement->bind_param("ssi", $new_username, $new_address, $_SESSION["user_id"]);
        $update_statement->execute();

        // Update session variables
        $_SESSION["username"] = $new_username;

        // Redirect back to profile page
        header("Location: profile.php");
        exit();
    }

    // Close connection
    $connection->close();
?>
