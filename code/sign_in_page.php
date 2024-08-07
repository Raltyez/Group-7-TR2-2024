<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="your_stylesheet.css">
</head>
<body>
    <?php include_once("header.php"); ?>
    <main style="display: flex; justify-content: center; align-items: center; background-image: url('shirt_background.webp'); height: 100vh; margin: 0;">
        <div class="wrapper">
            <form id="loginForm" onsubmit="submitForm(event)">
                <h1>Sign In</h1>
                <div class="input_box">
                    <input type="text" placeholder="Email" required name="email">
                    <i class='bx bx-user'></i>
                </div>
                <div class="input_box">
                    <input type="password" placeholder="Password" required name="password">
                    <i class='bx bx-lock-alt'></i>
                </div>
                <div class="remember_forgot">
                    <label></label>
                    <a href="forgot_password_form.php">Forgot password?</a>
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="register_link">
                    <p>Don't have an account? <a href="register_page.php">Sign Up</a></p>
                </div>
            </form>
        </div>
    </main>

    <script>
        function submitForm(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            
            fetch('login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'error') {
                    alert(data.message);
                } else {
                    alert(data.message);
                    window.location.href = "index.php"; // Redirect on success
                }
            })
            .catch(error => {
                alert('An error occurred: ' + error.message);
            });
        }
    </script>
</body>
</html>
