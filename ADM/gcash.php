<?php
include("config.php");
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:homepage.php');
};

if(isset($_POST['confirm_payment'])){

    $image_receipt = $_FILES['image_receipt']['name'];
    $image_size = $_FILES['image_receipt']['size'];
    $image_tmp_name = $_FILES['image_receipt']['tmp_name'];
    $image_folder = 'customer_receipt/'.$image_receipt;


    $insert_receipt = mysqli_query($conn, "UPDATE `orders` SET receipt_image = '$image_receipt' WHERE user_id = '$user_id' AND method = 'gcash' AND receipt_image = ''") or die('query failed');

    if($insert_receipt){
        if($image_size > 2000000){
        $message[] = 'image size is too large!';
        }else{
        move_uploaded_file($image_tmp_name, $image_folder);
        $message[] = 'receipt added successfully!';
        }
    }

    header('location:orders.php');
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

<section class="gcash_form">

    <form action="" method="POST" enctype="multipart/form-data">
        <h3>G-CASH PAYMENT</h3>
        <h2>SCAN TO PAY</h2><br>
        <img src="img/qrcode.jpg" alt=""><br><br>
        <h2>total price : ₱<?php  echo $_SESSION['grand_total']; ?></h2><br>
        <h2>Upload your receipt below</h2>
        <input type="file" name="image_receipt" accept="image/jpg, image/jpeg, image/png" required class="box"><br><br>
        <input type="submit" value="Confirm Payment" name="confirm_payment" class="btn">
    </form>

</section>

</body>
</html>