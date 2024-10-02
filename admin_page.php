<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
   $message[] = 'payment status has been updated!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_page.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<a class="title" id = "top"></a>

<?php include 'admin_header.php'; ?>

<a class = "gotopbtn" href ="#top"><i class = "fas fa-arrow-up"></i></a>


<section class="dashboard">

   <h1 class="title">dashboard</h1>

   <div class="box-container">

      <div class="box">
         <?php
            $total_pendings = 0;
            $select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
            if(mysqli_num_rows($select_pending) > 0){
               while($fetch_pendings = mysqli_fetch_assoc($select_pending)){
                  $total_price = $fetch_pendings['total_price'];
                  $total_pendings += $total_price;
               };
            };
         ?>
         <i class="fa-solid fa-clipboard-list"></i>
         <h3>$<?php echo $total_pendings; ?></h3>
         <p>Pending orders</p>
      </div>

      <div class="box">
         <?php
            $total_completed = 0;
            $select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
            if(mysqli_num_rows($select_completed) > 0){
               while($fetch_completed = mysqli_fetch_assoc($select_completed)){
                  $total_price = $fetch_completed['total_price'];
                  $total_completed += $total_price;
               };
            };
         ?>
         <i class="fa-solid fa-money-bill"></i>
         <h3>$<?php echo $total_completed; ?></h3>
         <p>completed payments</p>
      </div>

      <div class="box">
         <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
         ?>

         <i class="fa-solid fa-bag-shopping"></i>
         <h3><?php echo $number_of_orders; ?></h3>
         <p><a href="#placedorders">placed orders</a></p>
      </div>


      <div class="box">
         <?php
            $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            $number_of_account = mysqli_num_rows($select_account);
         ?>

         <i class="fa-solid fa-users"></i>
         <h3><?php echo $number_of_account; ?></h3>
         <p><a href = "#totalusers">total users</a></p>
      </div>


   </div>

</section>
<section class="users">

   <h1 class="title" id = "totalusers"> all users </h1>

   <div class="box-container">
      <?php
         $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
         while($fetch_users = mysqli_fetch_assoc($select_users)){
      ?>
      <div class="box">

         <p> Username : <span><?php echo $fetch_users['name']; ?></span> </p>
         <p> E-mail : <span><?php echo $fetch_users['email']; ?></span> </p>
         <p> Account type : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>

      </div>
      <?php
         };
      ?>
   </div>

</section>

<section class="orders">

   <h1 class="title" id = "placedorders">placed orders</h1>

   <div class="box-container">
      <?php
      $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <div class="box">
         <p> Name : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> Date : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>

         <p> Contact : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> E-mail : <span><?php echo $fetch_orders['email']; ?></span> </p>


         <p> Payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <p> Total : <span>$<?php echo $fetch_orders['total_price']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_payment">
               <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="pending">pending</option>
               <option value="completed">completed</option>
            </select>
            <input type="submit" value="update" name="update_order" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('delete this order?');" class="delete-btn">delete</a>
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

<script src="admin_script.js"></script>

</body>
</html>
