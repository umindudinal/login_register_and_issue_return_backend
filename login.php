<?php
session_start();

$registration_no = "";
$password = "";
$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
   $registration_no = $_POST["reg_no"];
   $password = $_POST["password"];

   if(empty($registration_no) || empty($password)) {
      $error = "Please enter both Registration No and Password.";
   } else {
      include "php/connection.php";
      $dbConnection = getDatabaseConnection();

      $statement = $dbConnection->prepare("SELECT FirstName, LastName, Email, Password, Role FROM user_registered_info WHERE RegistrationNo = ?");
      $statement->bind_param("s", $registration_no);
      $statement->execute();

      $statement->bind_result($first_name, $last_name, $email, $hashed_password, $role);
      
      if($statement->fetch()) {
         if(password_verify($password, $hashed_password)) {
            $_SESSION["reg_no"] = $registration_no;
            $_SESSION["first_name"] = $first_name;
            $_SESSION["last_name"] = $last_name;
            $_SESSION["email"] = $email;
            $_SESSION["role"] = $role;

            if($role == "Admin") {
               header("Location: php/dashboard.php");
            } else {
               header("Location: php/dashboard.php");
            }
            exit();
         }
      }

      $statement->close();
      $error = "Invalid Registration No or Password.";
   }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login to LMS</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <div class="form_container">
      <div class="form">
         <div class="close_btn">
            <a href="index.html"><i class="fa-solid fa-xmark"></i></a>
         </div>
         <div class="section1">
            <div class="title">
               <div class="title1">welcome</div>
               <div class="form_logo">
                  <img src="image/Logo.png" alt="" width="150px">
               </div>
               <div class="title3">library management system</div>
            </div>
            <div class="image">
               <img src="image/LMS 2 .png" alt="" width="200px">
            </div>
         </div>
         <div class="section2 login">
            <form action="#" method="post">
               <h2>Login Form</h2>
               <?php if(!empty($error)) { ?>
                  <div class="error_msg"><?= $error ?></div>
               <?php 
               } 
               ?>
               <div class="input_box">
                  <label>Registration No</label>
                  <input type="text" name="reg_no" required>
               </div>
               <div class="input_box">
                  <label>Password</label>
                  <input type="password" name="password" required>
               </div>
               <button type="submit" name="login">Login</button>
               <div class="buttom_link">
                  <p>I don't have an account <a href="register.php">Register</a></p>
               </div>
            </form>
         </div>
      </div>
   </div>
</body>
</html>