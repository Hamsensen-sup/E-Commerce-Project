

<header class="header">


   <div class="header-2">
      <div class="flex">
         <a href="shop.php" class="logo"><h2>ZAPATTOS</h2></a>
         <section class="search-form">
            <form action="" method="post">
               <input type="text" name="search" placeholder="Search something..." class="box">
               <input type="submit" name="submit" value="search" class="btn">
            </form>
         </section>

         <nav class="navbar">
            <a href="shop.php">Products</a>
            <a href="orders.php">Orders</a>
            <?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number);
            ?>
            <a href="wishlist.php">Wishlist</i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
            <a href="checkout.php">Checkout</a>
         </nav>

         <div class="icons">
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number);
            ?>
         </div>

         <div class="user-box">
            <p>Are you sure you want to logout <span><?php echo $_SESSION['user_name']; ?>?</span></p>
            <a href="logout.php" class="delete-btn">LOG OUT</a>
         </div>
      </div>
   </div>
   <section class="products" style="padding-top: 0;">



      <div class="box-container">
      <?php

         if(isset($_POST['submit'])){
            $search_item = $_POST['search'];
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%{$search_item}%'") or die('query failed');
            if(mysqli_num_rows($select_products) > 0){
            while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="post" class="box">
         <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="" class="image">
         <div class="name"><?php echo $fetch_product['name']; ?></div>
         <div class="price">Price: $<?php echo $fetch_product['price']; ?></div>
         <input type="number"  class="qty" name="product_quantity" min="1" value="1">
         <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
         <input type="submit" class="btn" value="add to cart" name="add_to_cart">
      </form>
      <?php
               }
            }else{
               echo '<p class="empty">no result found!</p>';
            }
         }
      ?>
      </div>


   </section>



</header>
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
