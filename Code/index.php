<?php 
    include_once("header.php");
?>
        <main>
            <div class="index_container">
                <div class="index_text">
                    <h1>Discover and Find Your Own Fashion!</h1> 
                    <p>Explore our curated collection of stylish clothing and accessories tailored to your unique taste.</p>
                    <a href="shop.php" class="explore_button">Explore Now</a>
                </div>
                <div class="index_image">
                    <button class="prev" onclick="changeImage(-1)">&#10094;</button>
                    <img src="https://i.ibb.co/Rvd0kHd/1.png" id="displayedImage">
                    <button class="next" onclick="changeImage(1)">&#10095;</button>
                </div>
            </div>
        </main>
    </body>
</html>

<?php 
    include_once("footer.html");
?>

<script>
    var images = ["https://i.ibb.co/Rvd0kHd/1.png", "https://i.ibb.co/nk4mN6L/2.png", "https://i.ibb.co/X4qzxGB/3.png"]; // Add image URLs here
    var currentIndex = 0;

    function changeImage(direction) {
        currentIndex += direction;
        if (currentIndex < 0) {
            currentIndex = images.length - 1;
        } else if (currentIndex >= images.length) {
            currentIndex = 0;
        }
        document.getElementById("displayedImage").src = images[currentIndex];
    }
</script>
