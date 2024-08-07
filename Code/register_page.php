<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="your_stylesheet.css">
</head>
<body>
    <?php include_once("header.php"); ?>
    <main style="display: flex; justify-content: center; align-items: center; background-image: url('shirt_background.webp'); height: 100vh; margin: 0;">
        <div class="wrapper">
            <form id="registrationForm" onsubmit="submitForm(event)">
                <h1>Sign Up</h1>
                <div class="input_box">
                    <input type="email" placeholder="Email" required name="email">
                    <i class='bx bx-envelope'></i>
                </div>
                <div class="input_box">
                    <input type="text" placeholder="Username" required name="username">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input_box">
                    <input type="password" placeholder="Password" required name="password">
                    <i class='bx bx-lock-alt'></i>
                </div>
                <div class="input_box">
                    <input type="password" placeholder="Confirm Password" required name="confirm_password">
                    <i class='bx bx-lock-alt'></i>
                </div>
                <div class="remember_forgot">
                    <label></label>
                    <a href="forgot_password_form.php">Forgot password?</a>
                </div>
                <button type="submit" class="btn">Register</button>
                <div class="register_link">
                    <p>Already have account? <a href="sign_in_page.php">Sign In</a></p>
                </div>
            </form>
        </div>
    </main>

    <script>
        function submitForm(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            
            fetch('register.php', {
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
