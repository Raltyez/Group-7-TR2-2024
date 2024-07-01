<?php 
    include_once("header.php");

    // Database Connection
    $servername = "localhost";
    $username = "root";   // Your database username
    $password_db = "";    // Your database password (leave empty if no password)
    $dbname = "users";    // Your database name
    $connection = new mysqli($servername, $username, $password_db, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Get user information
    $user_id = $_SESSION["user_id"];
    $statement = $connection->prepare("SELECT username, address FROM registration WHERE user_id = ?");
    $statement->bind_param("i", $user_id);
    $statement->execute();
    $result = $statement->get_result();
    $user = $result->fetch_assoc();
?>
<main style="display: flex; justify-content: center; align-items: center; background-image: url('purple_star.jpg'); height: 100vh; margin: 0;">
    <div class="wrapper">
        <h1 style="color: white;">Hello <?php echo htmlspecialchars($_SESSION["username"]); ?></h1>
        <form method="POST" action="change_profile.php">
            <div class="input_box">
                <input type="text" placeholder="Username" required name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                <i class='bx bx-user'></i>
            </div>
            <div class="input_box">
                <textarea id="address" name="address" rows="4" required><?php echo htmlspecialchars($user['address']); ?></textarea>
                <i class='bx bx-home-circle'></i>
            </div>
            <button type="submit" class="btn">Update</button>
        </form>
    </div>
</main>
</body>
</html>
