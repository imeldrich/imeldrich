<?php
include("config.php");

if(isset($_POST['submit'])){

   $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $name = mysqli_real_escape_string($conn, $filter_name);
   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $filter_email);
   $number = $_POST['number'];
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));
   $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
   $cpass = mysqli_real_escape_string($conn, md5($filter_cpass));
   $filter_user_type = filter_var($_POST['user_type'], FILTER_SANITIZE_STRING);
   $user_type = mysqli_real_escape_string($conn, $filter_user_type);

   $select_users = mysqli_query($conn, "SELECT * FROM `customer` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'user already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `customer`(name, email, contact_num, password, user_type) VALUES('$name', '$email', '$number', '$pass', '$user_type')") or die('query failed');
         $message[] = 'registered successfully!';
         header('location:login.php');
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


   
<section class="form-container">

   <form action="" method="post">
      <h3>register</h3>
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
      <input type="text" name="name" class="box" placeholder="Username" required>
      <input type="number" name="number" oninput="contact(this)" class="box" placeholder="Number" required>
      <input type="email" name="email" class="box" placeholder="Email" required>
      <input type="password" name="pass" class="box" placeholder="Password" required>
      <input type="password" name="cpass" class="box" placeholder="Confirm password" required>
      <input type="hidden" name="user_type" value="user">
      <input type="submit" class="btn" name="submit" value="register">
      <p>already have an account? <a href="login.php">Login here</a></p>
   </form>

</section>

<script src="js/script.js"></script>

</body>
</html>