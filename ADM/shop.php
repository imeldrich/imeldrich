<?php
include("config.php");
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
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
   
<?php include("header.php"); ?>

<section class="products">

<section class="title">
    <h1>LATEST PRODUCTS</h1><br>
    <hr>
</section>

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `shoes`") or die('query failed');
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
        <input type="number" min="1" max="<?php echo $fetch_products['stock']; ?>" oninput="quantity(this)" name="product_quantity" value="1" class="qty">
        <label><?php echo $fetch_products['stock']; ?> :STOCK</label>
        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
        <input type="submit" name="add_to_cart" value="Add to cart" class="option-btn">
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   </div>

</section>

<?php include("footer.php"); ?>

<script src="js/script.js"></script>

</body>
</html>