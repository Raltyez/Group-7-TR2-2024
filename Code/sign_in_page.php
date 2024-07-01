<?php 
    include_once("header.php");
?>
    <main  style="display: flex; justify-content: center; align-items: center; background-image: url('purple_star.jpg'); height: 100vh; margin: 0;">
        <div class="wrapper">
            <form action="login.php" method="POST">
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
                    <label><input type="checkbox" name="remember">Remember Me</label>
                    <a href="#">Forgot password?</a>
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="register_link">
                    <p>Don't have an account? <a href="register_page.php">Sign Up</a></p>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
