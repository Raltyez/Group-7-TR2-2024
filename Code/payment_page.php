<?php 
    include_once("header.php");
?>
        <main>
            <div class="payment_container">
                <form action="">
                    <div class="row">
                        <div class="col">
                            <h3 class="payment_title">billing address</h3>
                            <div class="payment_input_box">
                                <span>full name :</span>
                                <input type="text" placeholder="Alice Bob">
                            </div>
                            <div class="payment_input_box">
                                <span>email :</span>
                                <input type="email" placeholder="example@example.com">
                            </div>
                            <div class="payment_input_box">
                                <span>address :</span>
                                <input type="text" placeholder="123 James Road, Building Name #Floor-Room">
                            </div>
                            <div class="payment_input_box">
                                <span>city :</span>
                                <input type="text" placeholder="Singapore">
                            </div>
                            <div class="flex">
                                <div class="payment_input_box">
                                    <span>state :</span>
                                    <input type="text" placeholder="Singapore">
                                </div>
                                <div class="payment_input_box">
                                    <span>zip code :</span>
                                    <input type="text" placeholder="123456">
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
                                <input type="text" placeholder="Mr. Alice Bob">
                            </div>
                            <div class="payment_input_box">
                                <span>credit card number :</span>
                                <input type="number" placeholder="1111-1111-1111-1111">
                            </div>
                            <div class="payment_input_box">
                                <span>exp month :</span>
                                <input type="text" placeholder="January">
                            </div>
                            <div class="flex">
                                <div class="payment_input_box">
                                    <span>exp year :</span>
                                    <input type="number" placeholder="2024">
                                </div>
                                <div class="payment_input_box">
                                    <span>CVV :</span>
                                    <input type="text" placeholder="124">
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
