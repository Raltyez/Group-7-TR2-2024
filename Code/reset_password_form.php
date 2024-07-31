<?php 
    include_once("header.php");
?>
        <main style="display: flex; justify-content: center; align-items: center; background-image: url('purple_star.jpg'); height: 100vh; margin: 0;">
            <div class="wrapper">
                <form action="reset_password.php" method="POST">
                    <h1>Reset Password</h1>
                    <div class="input_box">
                        <input type="password" placeholder="New Password" required name="new_password">
                        <i class='bx bx-lock-alt'></i>
                    </div>
                    <div class="input_box">
                        <input type="password" placeholder="Confirm New Password" required name="confirm_new_password">
                        <i class='bx bx-lock-alt'></i>
                    </div>
                    <button type="submit" class="btn">Reset Password</button>
                </form>
            </div>
        </main>
    </body>
</html>
