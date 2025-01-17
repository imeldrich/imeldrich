<?php
include("config.php");
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:homepage.php');
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
}

if(isset($_POST['update_quantity'])){
    $cart_id = $_POST['cart_id'];
    $_SESSION['order_id'] = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    $size = $_POST['size'];

    mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity', size = '$size' WHERE id = '$cart_id'") or die('query failed');
    $message[] = 'order successfully updated!';
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

<section class="shopping-cart">

<section class="title">
    <h1>PRODUCT ADDED</h1><br>
    <hr>
</section>

    <div class="box-container">

    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
    ?>
    <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `shoes` WHERE stock") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            $fetch_products = mysqli_fetch_assoc($select_products);
         }
    ?>
    
    <div  class="box">
        <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
        <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="" class="image">
        <div class="name"><?php echo $fetch_cart['name']; ?></div>
        <div class="price">₱<?php echo $fetch_cart['price']; ?></div>
        <form action="" method="post">
            <input type="hidden" value="<?php echo $fetch_cart['id']; ?>" name="cart_id">
            <label for="size">SIZE:</label>
            <select name="size" class="size" id="size">
                    <option value="<?php echo $fetch_cart['size']; ?>" selected><?php echo $fetch_cart['size']; ?></option>
                    <option value="8">8</option>
                    <option value="8.5">8.5</option>
                    <option value="9">9</option>
                    <option value="9.5">9.5</option>
                    <option value="10">10</option>
                    <option value="10.5">10.5</option>
                    <option value="11">11</option>
            </select>
            <input type="number" min="1" max="<?php echo $fetch_products['stock']; ?>" oninput="quantity(this)" value="<?php echo $fetch_cart['quantity']; ?>" name="cart_quantity" class="qty">
            <label><?php echo $fetch_products['stock']; ?> :STOCK</label>
            <input type="submit" value="update" class="option-btn" name="update_quantity">
        </form>
        <div class="sub-total"> total : <span>₱<?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></span> </div>
    </div>
    <?php
    $grand_total += $sub_total;
        }
    }else{
        echo '<p class="empty">your cart is empty</p>';
    }
    ?>
    </div>

    <div class="more-btn">
        <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled' ?>" onclick="return confirm('delete all from cart?');">delete all</a>
    </div>

    <div class="cart-total">
        <p>total : <span>₱<?php echo $grand_total; ?></span></p>
        <a href="shop.php" class="option-btn">continue shopping</a>
        <a href="checkout.php" class="btn  <?php echo ($grand_total > 1)?'':'disabled' ?>">proceed to checkout</a>
    </div>

</section>

<?php include("footer.php"); ?>

<script src="js/script.js"></script>

</body>
</html>