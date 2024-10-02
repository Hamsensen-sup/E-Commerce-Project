<!-- The header element represents a group of introductory or navigational aids -->
<header class="header">

   <!-- The flex container allows its child elements to be aligned horizontally or vertically and to have flexible dimensions -->
   <div class="flex">

      <!-- The nav element represents a section of the document intended for navigation -->
      <nav class="navbar">

      </nav>

      <!-- The icons container contains links to different pages and buttons for the menu and user account -->
      <div class="icons">
        <!-- Link to the admin dashboard page -->
        <a href="admin_page.php"><div id="dashboard" class="fas fa-chart-line"></div></a>
        <!-- Link to the page to manage products -->
        <a href="admin_products.php"><div id="manage" class="fas fa-cart-plus"></div></a>
        <!-- Link to the page to manage other items -->
        <a href="admin_manage.php"><div id="manage" class="fas fa-list-check"></div></a>
         <!-- Button to toggle the menu -->
         <div id="menu-btn" class="fas fa-bars"></div>
         <!-- Button for the user account -->
         <div id="user-btn" class="fas fa-user"></div>

      </div>

      <!-- The account-box element contains a message and a logout button for the user -->
      <div class="account-box">
         <!-- Message to confirm logout with the user's name -->
         <p>Are you sure you want to logout <span><?php echo $_SESSION['admin_name']; ?>?</span></p>
         <!-- Logout button -->
         <a href="logout.php" class="delete-btn">logout</a>
      </div>

   </div>

</header>

<!-- PHP code to display a message if the $message variable is set -->
<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <!-- The message element contains a notification to the user -->
      <div class="message">
         <!-- The notification message -->
         <span>'.$message.'</span>
         <!-- Button to close the message -->
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
