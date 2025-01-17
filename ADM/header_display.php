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

        <a href="homepage.php">
          <p><img src="img/icon.png" id="home" class="logo"></p>
        </a>
       
        <nav class="navbar">
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="about_display.php">About</a></li>
                <li><a href="shop_display.php">shop</a></li>
            </ul>
        </nav>

        <div class="icons">
        <div id="user-btn" class="fas fa-user">login</div>

        <div class="account-box">
            <p>username : create account</p>
            <p>email : create account</p>
            <a href="login.php" class="acc_btn">login</a>
            <a href="register.php" class="acc_btn">Register</a>
        </div>

    </div>

</header>