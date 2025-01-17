<?php
include("config.php");
session_start();

if(isset($_POST['submit'])){

   $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $name = mysqli_real_escape_string($conn, $filter_name);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));

   $admin = mysqli_query($conn, "SELECT * FROM `admin` WHERE admin_acc = '$name' AND admin_pass = '$pass'") or die('query failed');


   if(mysqli_num_rows($admin) > 0){
      $fetch_admin = mysqli_fetch_assoc($admin);
      
      if($fetch_admin['admin_acc'] == 'admin'){
        
         $_SESSION['admin_name'] = $fetch_admin['admin_acc'];
         $_SESSION['admin_email'] = $fetch_admin['admin_pass'];
         $_SESSION['admin_id'] = $fetch_admin['id'];
         header('location:admin_dashboard.php');

      }else{
         $message[] = 'no user found!';
      }

   }else{
      $message[] = 'incorrect username or password!';
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
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=New+Amsterdam&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/9e87a4ade4.js" crossorigin="anonymous"></script>
</head>
<body>
   
<section class="form-container">

   <form action="" method="post">
      <h3>Admin login</h3>
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
      <input type="name" name="name" class="box" placeholder="Username" required>
      <input type="password" name="pass" class="box" placeholder="Password" required>
      <input type="submit" class="btn" name="submit" value="login">
   </form>

</section>

</body>
</html>