<?php
include("config.php");
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:homepage.php');
};

if(isset($_POST['order'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $brgy = mysqli_real_escape_string($conn, $_POST['brgy']);
    $municipality = mysqli_real_escape_string($conn, $_POST['municipality']);
    $province = mysqli_real_escape_string($conn, $_POST['province']);
    $postal = mysqli_real_escape_string($conn, $_POST['postal']);

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[] = $cart_item['name']. '('.$cart_item['quantity'].')' .' '. 'size('.$cart_item['size'].')';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ',$cart_products);

    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND brgy = '$brgy' AND municipality = '$municipality' AND province = '$province' AND postal = '$postal' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

    if($cart_total == 0){
        $message[] = 'your cart is empty!';
    }
    else{
        mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, brgy, municipality, province, postal, total_products, total_price) VALUES('$user_id', '$name', '$number', '$email', '$method', '$brgy', '$municipality', '$province', '$postal', '$total_products', '$cart_total')") or die('query failed');
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        $message[] = 'order placed successfully!';
    }
    
    if($_POST['method'] == "gcash"){
        header('location:gcash.php');
    }
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

<section class="title">
    <h1>Checkout</h1><br>
    <hr>
</section>

<section class="display-order">
    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
            $_SESSION['grand_total'] = $grand_total;
    ?>    
    <p> <?php echo $fetch_cart['name'] ?> <span>(<?php echo '₱'.$fetch_cart['price'].' x '.$fetch_cart['quantity']  ?>)</span> </p>
    <?php
        }
        }else{
            echo '<p class="empty">your cart is empty</p>';
        }
    ?>
    <div class="grand-total"> total price : <span>₱<?php echo $grand_total; ?></span></div>
</section>

<section class="checkout">

<?php   $select_users = mysqli_query($conn, "SELECT * FROM `customer`") or die('query failed');
        $fetch_user = mysqli_fetch_assoc($select_users);
?>

    <form action="" method="POST">

        <h3>place your order</h3>

        <div class="flex">
            <div class="inputBox">
                <span>Name :</span>
                <input type="text" name="name" value="<?php echo $fetch_user['name']?>">
            </div>
            <div class="inputBox">
                <span>Number :</span>
                <input type="number" name="number" oninput="contact(this)" value="<?php echo $fetch_user['contact_num']?>">
            </div>
            <div class="inputBox">
                <span>Email :</span>
                <input type="email" name="email" value="<?php echo $fetch_user['email']?>">
            </div>
            <div class="inputBox">
                <span>Payment Method :</span>
                <select name="method">
                    <option value="cash on delivery">Cash on delivery</option>
                    <option value="gcash">G-Cash</option>
                </select>
            </div>
            <?php 
                $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
                if(mysqli_num_rows($select_orders) >= 1){
                    $fetch_order = mysqli_fetch_assoc($select_orders);
            ?>
            <div class="inputBox">
                <span>Barangay :</span>
                <input type="text" name="brgy" value="<?php echo $fetch_order['brgy']?>">
            </div>
            <div class="inputBox">
                <span>Municipality :</span>
                <input type="text" name="municipality" value="<?php echo $fetch_order['municipality']?>">
            </div>
            <div class="inputBox">
                <span>Province/City :</span>
                <input type="text" name="province" value="<?php echo $fetch_order['province']?>">
            </div>
            <div class="inputBox">
                <span>Postal code :</span>
                <input type="number" class="postal" min="4" oninput="limitInput(this)" name="postal" value="<?php echo $fetch_order['postal']?>">
            </div>
            <?php
            }
            else{
            ?>
            <div class="inputBox">
                <span>Barangay :</span>
                <input type="text" name="brgy" required placeholder="ex. District 1">
            </div>
            <div class="inputBox">
                <span>Municipality :</span>
                <input type="text" name="municipality" required placeholder="ex. Lemery">
            </div>
            <div class="inputBox">
                <span>Province/City :</span>
                <input type="text" name="province" required placeholder="ex. Batangas">
            </div>
            <div class="inputBox">
                <span>Postal code :</span>
                <input type="number" class="postal" min="4" oninput="limitInput(this)" name="postal" required placeholder="ex. 4209">
            </div>
            <?php
            }
            ?>
        </div>

        <center><input type="submit" name="order" value="order now" class="btn"></center>

    </form>

</section>

<?php include("footer.php"); ?>

<script src="js/script.js"></script>

</body>
</html>