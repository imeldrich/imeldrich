<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(isset($_POST['update_profile'])){

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
   $update_num = mysqli_real_escape_string($conn, $_POST['update_num']);

   mysqli_query($conn, "UPDATE `customer` SET name = '$update_name', email = '$update_email', contact_num = '$update_num' WHERE id = '$user_id'") or die('query failed');

   $old_pass = $_POST['old_pass'];
   $current_pass = mysqli_real_escape_string($conn, md5($_POST['current_pass']));
   $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
   $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

   if(!empty($current_pass) || !empty($new_pass) || !empty($confirm_pass)){
      if($current_pass != $old_pass){
         $message[] = 'Current Password Not Matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'New Password Not Matched!';
      }else{
         mysqli_query($conn, "UPDATE `customer` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
         $message[] = 'Profile updated successfully!';
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
   
<section class="checkout">

<?php   $select_users = mysqli_query($conn, "SELECT * FROM `customer`") or die('query failed');
        $fetch_user = mysqli_fetch_assoc($select_users);
?>

    <form action="" method="POST">
      <h3>Update Profile</h3>
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

        <div class="flex">
            <div class="inputBox">
                <span>Username :</span>
                <input type="text" name="update_name" value="<?php echo $fetch_user['name']?>">
            </div>
            <div class="inputBox">
                <span>Current password :</span>
                <input type="password" name="current_pass" required placeholder="Current password">
            </div>
            <div class="inputBox">
                <span>Number :</span>
                <input type="number" name="update_num" oninput="contact(this)" value="<?php echo $fetch_user['contact_num']?>">
            </div>
            <div class="inputBox">
                <span>New password :</span>
                <input type="password" name="new_pass" required placeholder="New password">
            </div>
            <div class="inputBox">
                <span>Email :</span>
                <input type="email" name="update_email" value="<?php echo $fetch_user['email']?>">
            </div>
            <div class="inputBox">
                <span>Confirm new password :</span>
                <input type="password" name="confirm_pass" required placeholder="Confirm new password">
            </div>
        </div>
               <input type="hidden" name="old_pass" value="<?php echo $fetch_user['password']; ?>">
        <center><input type="submit" name="update_profile" value="UPDATE PROFILE" class="btn"></center>
        <center><a href="home.php" class="delete-btn">CANCEL</a></center>

    </form>

</section>

<script src="js/script.js"></script>

</body>
</html>