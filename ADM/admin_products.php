<?php
include("config.php");
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $stock = mysqli_real_escape_string($conn, $_POST['stock']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `shoes` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'product name already exist!';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO `shoes`(name, price, stock, image) VALUES('$name', '$price', $stock, '$image')") or die('query failed');

      if($insert_product){
         if($image_size > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'product added successfully!';
         }
      }
   }
}

if(isset($_POST['delete_selected'])){
   if(isset($_POST['delete_ids'])){
      $delete_ids = $_POST['delete_ids'];
      foreach($delete_ids as $delete_id){
         $select_delete_image = mysqli_query($conn, "SELECT image FROM `shoes` WHERE id = '$delete_id'") or die('query failed');
         $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
         unlink('uploaded_img/'.$fetch_delete_image['image']);
         mysqli_query($conn, "DELETE FROM `shoes` WHERE id = '$delete_id'") or die('query failed');
         mysqli_query($conn, "DELETE FROM `cart` WHERE product_id = '$delete_id'") or die('query failed');
      }
      header('location:admin_products.php');
   }
   else{
      $message[] = 'No products selected for deletion!';
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
   
<?php include("admin_header.php"); ?>

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add new product</h3>
      <input type="text" name="name" class="box" required placeholder="Enter Name">
      <input type="number" name="price" min="0" class="box" required placeholder="Enter Price">
      <input type="number" name="stock" min="0" class="box" required placeholder="Available stock">
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" required class="box">
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<section class="show-products">

   <form action="" method="POST">
      
      <div class="box-container">

         <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `shoes`") or die('query failed');
            if(mysqli_num_rows($select_products) > 0){
               while($fetch_products = mysqli_fetch_assoc($select_products)){
         ?>
         <label foreach="checkbox">
         <div class="box">
            <input type="checkbox" name="delete_ids[]" id="checkbox" value="<?php echo $fetch_products['id']; ?>" class="delete-checkbox">
            <div class="price">₱<?php echo $fetch_products['price']; ?></div>
            <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
            <div class="name"><?php echo $fetch_products['name']; ?></div>
            <a href="admin_update_product.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
         </div>
         </label>
         <?php
            }
         }else{
            echo '<p class="empty">no products added yet!</p>';
         }
         ?>

      </div>
      
      <div class="more-btn">
         <center>
            <input type="submit" name="delete_selected" value="Delete items" class="delete-btn" onclick="return confirm('Are you sure you want to delete the selected products?');">
         </center>
      </div>
      
   </form>
   
</section>

<script src="js/admin_script.js"></script>

</body>
</html>