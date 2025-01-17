<?php
include("config.php");
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

$select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');

if(isset($_POST['cancel'])){
    while($fetch_orders = mysqli_fetch_assoc($select_orders)){
        if($fetch_orders['order_status'] == 'pending'){
            $order_id = $_POST['order_id'];
            mysqli_query($conn, "UPDATE `orders` SET order_status = 'cancelled' WHERE id = '$order_id'") or die('query failed');
        }
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


<section class="placed-orders">


<section class="title">
    <h1>PLACED ORDERS</h1><br>
    <hr>
</section>

    <div class="box-container">

    <?php
        $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_orders) > 0){
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){
    ?>
    <div class="box">
        <p> Placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
        <p> Name : <span><?php echo $fetch_orders['name']; ?></span> </p>
        <p> Number : <span><?php echo $fetch_orders['number']; ?></span> </p>
        <p> Email : <span><?php echo $fetch_orders['email']; ?></span> </p>
        <p> Address : <span><?php echo $fetch_orders['brgy'].', ' .$fetch_orders['municipality'].', ' .$fetch_orders['province'].', ' .$fetch_orders['postal']; ?></span> </p>
        <p> Payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
        <p> Your order/s : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
        <p> Total price : <span>₱<?php echo $fetch_orders['total_price']; ?></span> </p>
        
        <p> Order Status : <span style="color:
    <?php 
       if($fetch_orders['order_status'] == 'pending'){echo 'yellowgreen'; }
       elseif($fetch_orders['order_status'] == 'in process'){echo 'blue'; }
       elseif($fetch_orders['order_status'] == 'to ship'){echo 'orange'; }
       elseif($fetch_orders['order_status'] == 'cancelled'){echo 'red'; }
       elseif($fetch_orders['order_status'] == 'completed'){echo 'green'; }
    ?>"> 
      <?php echo $fetch_orders['order_status']; ?></span></p>
        <form action="" method="POST">
        <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
        <input type="submit" name="cancel" value="CANCEL ORDER" class="delete-btn <?php if($fetch_orders['order_status'] == 'in process' || $fetch_orders['order_status'] == 'to ship' || $fetch_orders['order_status'] == 'cancelled' || $fetch_orders['order_status'] == 'completed'){
            echo 'disabled';
        }?>" onclick="return confirm('Cancel Order?');">
        </form>
      </div>
    <?php
        }
    }else{
        echo '<p class="empty">no orders placed yet!</p>';
    }
    ?>
    </div>

</section>

<?php include("footer.php"); ?>

<script src="js/script.js"></script>

</body>
</html>