<?php 
    include_once("header.php");
?>
        <main>
            <div class="container">
                <h3 class="title"> Shop </h3>
                <div class="products-container">
                    <div class="product" data-name="p-1">
                        <img src="1.png">
                        <h3>Sound of Shephard</h3>
                        <div class="price">$50</div>
                    </div>
                    <div class="product" data-name="p-2">
                        <img src="2.png">
                        <h3>Glory</h3>
                        <div class="price">$40</div>
                    </div>
                    <div class="product" data-name="p-3">
                        <img src="3.png">
                        <h3>PRAISE</h3>
                        <div class="price">$35</div>
                    </div>
                </div>
            </div>
            <div class="products-preview">
                <div class="preview" data-target="p-1">
                    <i class="fas fa-times"></i>
                    <img src="1.png">
                    <h3>Sound of Shephard</h3>
                    <p>Let the sound of the shephard rests in your ears</p>
                    <div class="price">$50</div>
                    <div class="buttons">
                        <a href="#" class="buy">Buy now</a>
                        <a href="#" class="cart">Add to cart</a>
                    </div>
                </div>
                <div class="preview" data-target="p-2">
                    <i class="fas fa-times"></i>
                    <img src="2.png">
                    <h3>Glory</h3>
                    <p>You can reach that glory by keep on going!</p>
                    <div class="price">$50</div>
                    <div class="buttons">
                        <a href="#" class="buy">Buy now</a>
                        <a href="#" class="cart">Add to cart</a>
                    </div>
                </div>
                <div class="preview" data-target="p-3">
                    <i class="fas fa-times"></i>
                    <img src="3.png">
                    <h3>PRAISE</h3>
                    <p>Shout of PRAISE, cause you believe!</p>
                    <div class="price">$50</div>
                    <div class="buttons">
                        <a href="#" class="buy">Buy now</a>
                        <a href="#" class="cart">Add to cart</a>
                    </div>
                </div>
            </div>
            <script>
                let preveiwContainer = document.querySelector('.products-preview');
                let previewBox = preveiwContainer.querySelectorAll('.preview');

                document.querySelectorAll('.products-container .product').forEach(product =>{
                product.onclick = () =>{
                    preveiwContainer.style.display = 'flex';
                    let name = product.getAttribute('data-name');
                    previewBox.forEach(preview =>{
                    let target = preview.getAttribute('data-target');
                    if(name == target){
                        preview.classList.add('active');
                    }
                    });
                };
                });

                previewBox.forEach(close =>{
                close.querySelector('.fa-times').onclick = () =>{
                    close.classList.remove('active');
                    preveiwContainer.style.display = 'none';
                };
                });
            </script>
        </main>
    </body>
</html>