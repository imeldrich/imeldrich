<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<div id="top-nav">
    <h1><center>Step Into Style with ADM Shoe Planet</center></h1>
</div>

<header class="header">

    <div class="flex">

        <a href="home.php">
            <p><img src="img/icon.png" id="home" class="logo"></p>
        </a> 

        <nav class="navbar">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="shop.php">shop</a></li>
                <li><a href="orders.php">Orders</a></li>
            </ul>
        </nav>

        <div class="icons">
            <div id="user-btn" class="fas fa-user"></div>
            <?php
                $select_cart_count = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                $cart_num_rows = mysqli_num_rows($select_cart_count);
            ?>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?php echo $cart_num_rows; ?>)</span></a>      
        </div>

        <div class="account-box">
            <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <?php
                $select = mysqli_query($conn, "SELECT * FROM `customer` WHERE id = '$user_id'") or die('query failed');
                if(mysqli_num_rows($select) > 0){
                    $fetch = mysqli_fetch_assoc($select);
                }
            ?>
            <h1><?php echo $_SESSION['user_name']; ?></h1>
            <a href="update_profile.php" class="option-btn">Update Profile</a>
            <a href="homepage.php" class="delete-btn">logout</a>
        </div>

    </div>

</header>