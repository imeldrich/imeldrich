<?php
include("config.php");
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:homepage.php');
};

if(isset($_POST['send'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

    if(mysqli_num_rows($select_message) > 0){
        $message[] = 'message sent already!';
    }else{
        mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
        $message[] = 'message sent successfully!';
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

<section class="contact">

<?php  
    $select_users = mysqli_query($conn, "SELECT * FROM `customer` WHERE id = '$user_id'") or die('query failed');
    $fetch_user = mysqli_fetch_assoc($select_users);
?>

    <form action="" method="post">
        <h3>send us message!</h3>
        <input type="text" name="name" class="box" value="<?php echo $fetch_user['name']?>">
        <input type="email" name="email" class="box" value="<?php echo $fetch_user['email']?>">
        <input type="number" name="number" class="box" oninput="contact(this)" value="<?php echo $fetch_user['contact_num']?>">
        <textarea name="message" class="box" placeholder="Leave us a message" required cols="30" rows="10"></textarea>
        <input type="submit" value="send message" name="send" class="btn">
    </form>

</section>

<?php include("footer.php"); ?>

<script src="js/script.js"></script>

</body>
</html>