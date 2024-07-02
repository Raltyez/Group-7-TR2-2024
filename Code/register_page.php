<?php 
    include_once("header.php");
?>
        <main style="display: flex; justify-content: center; align-items: center; background-image: url('purple_star.jpg'); height: 100vh; margin: 0;">
            <div class="wrapper">
                <form action="register.php" method="post">
                    <h1>Sign Up</h1>
                    <div class="input_box">
                        <input type="text" placeholder="Email" required name="email">
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
                        <a href="#">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn">Register</button>
                    <div class="register_link">
                        <p>Already have account? <a href="sign_in_page.php">Sign In</a></p>
                    </div>
                </form>
            </div>
        </main>
    </body>
</html>
