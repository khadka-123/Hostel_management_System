<?php
session_start();

include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) { //should match with name
   $email = $_POST['email'];
   $password = $_POST['password'];
   $status = $_POST['status'];

   //table name
   $table_name = "";
   if ($status == "User") {
      $table_name = "student";
   } else $table_name = "admin";

   $query = mysqli_query($conn, "select * from $table_name where email='$email'");
   $row = mysqli_fetch_assoc($query);


   if (mysqli_num_rows($query) > 0) {
      if ($password == $row["password"]) {
         //set email 
         $_SESSION['email'] = $email;

         if ($status == "User") {
            header('Location: ./student/student_homepage.html');
         } else {
            header("Location: ./admin/admin_homepage.html");
         }
      } else {
         header("Location:login.php");
         echo  "<script> alert('1');</script>";
      }
   } else {
      echo "<script> alert('User not Registered');</script>";
   }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!--=============== REMIXICONS ===============-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">

   <!--=============== CSS ===============-->
   <link rel="stylesheet" href="./assets/css/login.css">

   <title>Login</title>
</head>

<body>
   <div class="login">
      <img src="assets/img/login-bg.png" alt="image" class="login__bg">

      <form action="login.php" class="login__form" autocomplete="off" method="POST">
         <h1 class="login__title">Login</h1>

         <div class="login__inputs">
            <div class="login__box">
               <input type="email" placeholder="Email ID" required class="login__input" name="email">
               <i class="ri-mail-fill"></i>
            </div>

            <div class="login__box">
               <input type="password" placeholder="Password" required class="login__input" name="password">
               <i class="ri-lock-2-fill"></i>
            </div>

            <div id="conta">
               <div class="login__box" id="drop_menu">
                  <select name="status" id="dropmenu">
                     <option value="User">User</option>
                     <option value="Admin">Admin</option>
                  </select>
               </div>
               <div class="login__box" id="about_us">
                  <a href="about_us.html" style="color: whitesmoke">About us</a>
               </div>
            </div>
         </div>

         <button type="submit" class="login__button" name="login">Login</button>

         <div class="login__register">
            Don't have an account? <a href="registration.php">Register</a>
         </div>
      </form>
   </div>
</body>

</html>