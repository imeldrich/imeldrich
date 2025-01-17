<?php
include("config.php");
?>

<!DOCTYPE html>
<html lang="en">
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
   
<?php include("header_display.php"); ?>

<section class="title">
    <h1>About</h1><br>
    <hr>
</section>

<section class="about">

    <div class="flex">

        <div class="image">
            <img src="img/about.jpg" alt="">   
        </div>

        <div class="content">
            <p>Welcome to ADM Shoe Planet,  your ultimate destination for the latest sports shoes. Our passion for sports and quality footwear led us to create a space where athletes and enthusiasts can find the perfect pair of shoes. At ADM Shoe Planet, we take pride in offering a wide range of premium sports shoes designed to elevate your performance and style.</p>
        </div>
    </div>
    <br><br><br><br>

    <div class="flex">
        <div class="content">
            <p>ADM Shoe Planet, which was established in 2017 and is owned by Arnold Maninga, began with its first branch located in Brgy. Palanas, Lemery, Batangas, offering a variety of footwear at different price points depending on the quality and brand, and has since expanded to include a second branch situated at Brgy. Illustre Avenue and Brgy. District 4.</p>
        </div>

        <div class="image">
            <img src="img/owner_pic.jpg" alt="">   
        </div>
    </div>
    <br>
    <br>
    
</section>

<?php include("footer_display.php"); ?>

<script src="js/script.js"></script>

</body>
</html>