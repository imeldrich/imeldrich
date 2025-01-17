<?php
include("config.php");
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update_order'])){
   $order_id = $_POST['order_id'];
   $update_order = $_POST['update_order'];
   mysqli_query($conn, "UPDATE `orders` SET order_status = '$update_order' WHERE id = '$order_id'") or die('query failed');
   $message[] = 'payment status has been updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM Shoe Planet</title>
    <link rel="icon" type="image/png" href="img/icon.png">
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=New+Amsterdam&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/9e87a4ade4.js" crossorigin="anonymous"></script>
</head>
<body>
   
<?php include("admin_header.php"); ?>

<section class="placed-orders">

   <h1 class="title">placed orders</h1>

   <div class="box-container">

      <?php
      
      $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <div class="box">
         <p> User id : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
         <p> Placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> Name : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> Number : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> Email : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> Address : <span><?php echo $fetch_orders['brgy'].', ' .$fetch_orders['municipality'].', ' .$fetch_orders['province'].', ' .$fetch_orders['postal']; ?></span> </p>
         <p> Total products : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Total price : <span>₱<?php echo $fetch_orders['total_price']; ?></span> </p>
         <p> Payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <?php if($fetch_orders['method'] == "gcash"){?>
         <p><img src="customer_receipt/<?php echo $fetch_orders['receipt_image']; ?>" alt=""></p>
         <?php } ?>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_order">
               <option disabled selected><?php echo $fetch_orders['order_status']; ?></option>
               <option value="pending">pending</option>
               <option value="in process">in process</option>
               <option value="to ship">to ship</option>
               <option value="cancelled">cancelled</option>
               <option value="completed">completed</option>
            </select>
            <input type="submit" value="update" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
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

<script src="js/admin_script.js"></script>

</body>
</html>