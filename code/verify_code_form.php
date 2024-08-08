<?php 
    include_once("header.php");
?>
        <main style="display: flex; justify-content: center; align-items: center; background-image: url('purple_star.jpg'); height: 100vh; margin: 0;">
            <div class="wrapper">
                <form action="verify_code.php" method="POST">
                    <h1>Enter Confirmation Code</h1>
                    <div class="input_box">
                        <input type="text" placeholder="Confirmation Code" required name="confirmation_code">
                        <i class='bx bx-key'></i>
                    </div>
                    <button type="submit" class="btn">Verify Code</button>
                </form>
            </div>
        </main>
    </body>
</html>
