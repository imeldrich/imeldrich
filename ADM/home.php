<?php
include("config.php");
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:homepage.php');
}

if(isset($_POST['add_to_cart'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_size = $_POST['product_size'];
   $product_quantity = $_POST['product_quantity'];
   $product_image = $_POST['product_image'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
   }
   else{
       mysqli_query($conn, "INSERT INTO `cart`(user_id, product_id, name, price, size, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_size', '$product_quantity', '$product_image')") or die('query failed');
   }

   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM Shoe Planet</title>
    <link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=New+Amsterdam&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/9e87a4ade4.js" crossorigin="anonymous"></script>
</head>
<body>

<?php include("header.php");?>

    <section class="home">
        <div class="content">
            <h3>ADM SHOE PLANET</h3>
            <p>STEP INTO STYLE</p>
        </div>
    </section>

    <section>
        <center>
            <h1 class="homeTitle">NEW ARRIVAL</h1>
            <hr>

            <div id="slideshow">
                <div class="slide active">
                    <h2>KOBE 6</h2>
                    <img src="shoes_adm/KOBE_6-removebg-preview.png">
                </div>
                <div class="slide">
                    <h2>ANTA SHOCKWAVE 5</h2>
                    <img src="shoes_adm/ANTA_SHOCKWAVE_5-removebg-preview.png">
                </div>
                <div class="slide">
                    <h2>TRAVIS SCOTT</h2>
                    <img src="shoes_adm/TRAVIS_SCOTT-removebg-preview.png">
                </div>
                <div class="slide">
                    <h2>VANS POTATO</h2>
                    <img src="shoes_adm/VANS_POTATO-removebg-preview.png">
                </div>
            </div>

            <h1 class="homeTitle">PROMOS</h1>
            <hr>

            <script>
                let currentSlide = 0;
                const slides = document.querySelectorAll('.slide');
                setInterval(() => {
                slides[currentSlide].classList.remove('active');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.add('active');
                }, 2000); // Change slide every 2 seconds
            </script>
        </center>
    </section>
    
<section class="products">

<div class="box-container">
      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `shoes` LIMIT 4") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="POST" class="box">
         <div class="price">₱<?php echo $fetch_products['price']; ?></div>
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">

         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <label for="size">SIZE:</label>
         <select name="product_size" class="size" id="size">
                <option value="8">8</option>
                <option value="8.5">8.5</option>
                <option value="9">9</option>
                <option value="9.5">9.5</option>
                <option value="10">10</option>
                <option value="10.5">10.5</option>
                <option value="11">11</option>
        </select>
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
         <input type="hidden" name="product_quantity" value="1">
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
         <input type="submit" name="add_to_cart" value="Add to cart" class="option-btn">
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">No Available Shoes Yet!</p>';
      }
      ?>
   </div>

   <div class="more-btn">
      <a href="shop.php" class="option-btn">load more</a>
   </div>

</section>

<h1 class="homeTitle">STORE LOCATION</h1>
        <hr>
        <div class="map"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d968.3316620085998!2d120.91593076955598!3d13.879406499157865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd0a1f06162285%3A0xad5b930b6044e6f8!2s396%20Illustre%20Ave%2C%20Lemery%2C%20Batangas!5e0!3m2!1sen!2sph!4v1728054691103!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>

<?php include("footer.php"); ?>

<script src="js/script.js"></script>
</body>
</html>