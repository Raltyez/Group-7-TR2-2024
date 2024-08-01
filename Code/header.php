<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <link rel="stylesheet" href="style.css">
        <title>ComiTop</title>
    </head>
    <body>
        <header>
            <div class="navbar">
                <div class="logo"><a href="index.php">ComiTop</a></div>
                <ul class="links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="feature.php">Feature</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
                <ul class="action_btn">
                    <li><a href="cart.php"><i class='bx bx-shopping-bag' id="bag_nav"></i></a></li>
                    <?php
                        if(isset($_SESSION["user_id"])) {
                    ?>
                    <li class="dropdown">
                        <a href="profile.php" id="login_nav"><?php echo $_SESSION["username"];?></a>
                        <div class="dropdown-content">
                            <a href="profile.php">Profile</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </li>
                    <?php
                        } else {
                    ?>
                        <li><a href="sign_in_page.php"><p id="login_nav">Login</p></a></li>
                    <?php
                        }
                    ?>
                </ul>
                <div class="toggle_btn"><i class='bx bx-menu'></i></div>
            </div>

            <div class="mobile_nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="feature.php">Feature</a></li>
                <li><a href="contact.php">Contact</a></li>
            </div> 
        </header>
        <script>
            const mobile_nav = document.querySelector(".mobile_nav")
            const toggle_btn = document.querySelector(".toggle_btn")
            const toggle_btn_icon = document.querySelector(".toggle_btn i")

            toggle_btn.onclick = function() {
                mobile_nav.classList.toggle('open')
                const is_open = mobile_nav.classList.contains("open")
            }
        </script>
    </body>
</html>
