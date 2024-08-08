<?php 
    include_once("header.php");

    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page if not logged in
        header("Location: sign_in_page.php");
        exit();
    }
?>
        <main>
            <div class="payment_container">
                <form action="process_payment.php" method="post">
                    <div class="row">
                        <div class="col">
                            <h3 class="payment_title">billing address</h3>
                            <div class="payment_input_box">
                                <span>full name :</span>
                                <input type="text" name="full_name" placeholder="Alice Bob" required>
                            </div>
                            <div class="payment_input_box">
                                <span>email :</span>
                                <input type="email" name="email" placeholder="example@example.com" required>
                            </div>
                            <div class="payment_input_box">
                                <span>address :</span>
                                <input type="text" name="address" placeholder="123 James Road, Building Name #Floor-Room" required>
                            </div>
                            <div class="payment_input_box">
                                <span>city :</span>
                                <input type="text" name="city" placeholder="Singapore" required>
                            </div>
                            <div class="flex">
                                <div class="payment_input_box">
                                    <span>state :</span>
                                    <input type="text" name="state" placeholder="Singapore" required>
                                </div>
                                <div class="payment_input_box">
                                    <span>zip code :</span>
                                    <input type="text" name="zip_code" placeholder="123456" required>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <h3 class="payment_title">payment</h3>
                            <div class="payment_input_box">
                                <span>cards accepted :</span>
                                <i class="fa-solid fa-credit-card"></i>
                                <i class="fa-solid fa-money-bill"></i>
                                <i class="fa-brands fa-paypal"></i>
                            </div>
                            <div class="payment_input_box">
                                <span>name on card :</span>
                                <input type="text" name="card_name" placeholder="Mr. Alice Bob" required>
                            </div>
                            <div class="payment_input_box">
                                <span>credit card number :</span>
                                <input type="number" name="card_number" placeholder="1111-1111-1111-1111" required>
                            </div>
                            <div class="payment_input_box">
                                <span>exp month :</span>
                                <input type="text" name="exp_month" placeholder="January" required>
                            </div>
                            <div class="flex">
                                <div class="payment_input_box">
                                    <span>exp year :</span>
                                    <input type="number" name="exp_year" placeholder="2024" required>
                                </div>
                                <div class="payment_input_box">
                                    <span>CVV :</span>
                                    <input type="text" name="cvv" placeholder="124" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Checkout" class="payment_submit_btn">
                </form>
            </div>
        </main>
    </body>
</html>

<?php 
    include_once("footer.html");
?>
