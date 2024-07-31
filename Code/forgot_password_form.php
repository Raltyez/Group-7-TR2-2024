<?php 
    include_once("header.php");
?>
        <main style="display: flex; justify-content: center; align-items: center; background-image: url('purple_star.jpg'); height: 100vh; margin: 0;">
            <div class="wrapper">
                <form action="send_confirmation_code.php" method="POST">
                    <h1>Forgot Password</h1>
                    <div class="input_box">
                        <input type="email" placeholder="Enter your email" required name="email">
                        <i class='bx bx-envelope'></i>
                    </div>
                    <button type="submit" class="btn">Send Confirmation Code</button>
                </form>
            </div>
        </main>
    </body>
</html>
