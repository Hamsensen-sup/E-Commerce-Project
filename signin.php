<?php

// include the config file to connect to the database
include 'config.php';

// check if the form has been submitted
if (isset($_POST['submit'])) {
    // escape special characters in the form input to prevent SQL injection attacks
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // hash the password using md5 before saving it to the database
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $user_type = $_POST['user_type'];

    // check if a user with the same email and password already exists in the database
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    // if a user with the same email and password already exists
    if (mysqli_num_rows($select_users) > 0) {
        // set an error message
        $message[] = 'user already exist!';
    } else {
        // if the confirm password does not match the password
        if ($pass != $cpass) {
            // set an error message
            $message[] = 'confirm password not matched!';
        } else {
            // if the form is valid, insert the new user into the database
            mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
            // set a success message
            $message[] = 'registered successfully!';
            // redirect the user to the login page
            header('location:login.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>



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

<div class="form-container">
  <form action="" method="post">
    <h3>Sign In</h3>
    <input
      type="text"
      name="name"
      placeholder="Name"
      required
      class="box"
    >
    <input
      type="email"
      name="email"
      placeholder="E-mail"
      required
      class="box"
    >
    <input
      type="password"
      name="password"
      placeholder="Password"
      required
      class="box"
    >
    <input
      type="password"
      name="cpassword"
      placeholder="Confirm password"
      required
      class="box"
    >
    <select name="user_type" class="box">
      <option value="user">User</option>
      <option value="admin">Admin</option>
    </select>
    <input
      type="submit"
      name="submit"
      value="Sign In"
      class="btn"
    >
    <p>
      Already have an account?
      <a href="login.php">Log In!</a>
    </p>
  </form>
</div>

</body>
</html>
