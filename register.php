<?php
session_start();

include 'php/connection.php';
$dbConnection = getDatabaseConnection();

// Initialize variables
$registration_no = "";
$first_name = "";
$last_name = "";
$password = "";
$confirm_password = "";
$email = "";
$phone = "";

$registration_no_error = "";
$first_name_error = "";
$last_name_error = "";
$password_error = "";
$confirm_password_error = "";
$email_error = "";
$phone_error = "";

$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
   // Get input values safely
   $registration_no = trim($_POST['reg_no'] ?? '');
   $first_name = trim($_POST['first_name'] ?? '');
   $last_name = trim($_POST['last_name'] ?? '');
   $password = $_POST['password'] ?? '';
   $confirm_password = $_POST['confirm_password'] ?? '';
   $email = trim($_POST['email'] ?? '');
   $phone = trim($_POST['phone'] ?? '');

   // Validation
   if (empty($registration_no)) {
      $registration_no_error = "Registration No is required.";
      $error = true;
   }

   $dbConnection = getDatabaseConnection();
   $statement = $dbConnection->prepare("SELECT RegistrationNo FROM user_registered_info WHERE RegistrationNo = ?");
   $statement->bind_param("s", $registration_no);
   $statement->execute();
   $statement->store_result();

   if ($statement->num_rows > 0) {
      $registration_no_error = "You have already registered with this Registration No.";
      $error = true;
   }
   $statement->close();

   if (empty($first_name)) {
      $first_name_error = "First Name is required.";
      $error = true;
   }
   if (empty($last_name)) {
      $last_name_error = "Last Name is required.";
      $error = true;
   }
   if (empty($password)) {
      $password_error = "Password is required.";
      $error = true;
   }
   if ($password !== $confirm_password) {
      $confirm_password_error = "Passwords do not match.";
      $error = true;
   }
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_error = "Email format is not valid.";
      $error = true;
   }
   if (empty($phone)) {
      $phone_error = "Phone is required.";
      $error = true;
   }

   // Insert if no errors
   if (!$error) {
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $statement = $dbConnection->prepare("INSERT INTO user_registered_info 
         (RegistrationNo, FirstName, LastName, Password, ConfirmPassword, Email, MobileNo) 
         VALUES (?, ?, ?, ?, ?, ?, ?)");
      $statement->bind_param("sssssss", $registration_no, $first_name, $last_name, $hashed_password, $hashed_password, $email, $phone);
      $statement->execute();

      $_SESSION["registration_no"] = $registration_no;
      $_SESSION["first_name"] = $first_name;
      $_SESSION["last_name"] = $last_name;
      $_SESSION["email"] = $email;
      $_SESSION["phone"] = $phone;

      $statement->close();
      $dbConnection->close();

      header("Location: php/dashboard.php");
      exit();
   }

   $dbConnection->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register to LMS</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <div class="form_container">
      <div class="form">
         <div class="section1">
            <div class="title">
               <div class="title1">Welcome</div>
               <div class="form_logo">
                  <img src="image/Logo.png" alt="Logo" width="150px">
               </div>
               <div class="title3">Library Management System</div>
            </div>
            <div class="image">
               <img src="image/LMS 1 .png" alt="LMS Image">
            </div>
         </div>

         <div class="section2">
            <form action="#" method="post">
               <h2>Registration Form</h2>

               <div class="input_box">
                  <label>Registration No</label>
                  <input type="text" name="reg_no" value="<?= htmlspecialchars($registration_no) ?>">
                  <span class="error"><?= $registration_no_error ?></span>
               </div>

               <div class="box2">
                  <div class="input_box">
                     <label>First Name</label>
                     <input type="text" name="first_name" value="<?= htmlspecialchars($first_name) ?>">
                     <span class="error"><?= $first_name_error ?></span>
                  </div>
                  <div class="input_box">
                     <label>Last Name</label>
                     <input type="text" name="last_name" value="<?= htmlspecialchars($last_name) ?>">
                     <span class="error"><?= $last_name_error ?></span>
                  </div>
               </div>

               <div class="box2">
                  <div class="input_box">
                     <label>Password</label>
                     <input type="password" name="password">
                     <span class="error"><?= $password_error ?></span>
                  </div>
                  <div class="input_box">
                     <label>Confirm Password</label>
                     <input type="password" name="confirm_password">
                     <span class="error"><?= $confirm_password_error ?></span>
                  </div>
               </div>

               <div class="input_box">
                  <label>Email</label>
                  <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">
                  <span class="error"><?= $email_error ?></span>
               </div>

               <div class="input_box">
                  <label>Mobile No</label>
                  <input type="number" name="phone" value="<?= htmlspecialchars($phone) ?>">
                  <span class="error"><?= $phone_error ?></span>
               </div>

               <button type="submit" name="register">Register</button>

               <div class="buttom_link">
                  <p>Already have an account? <a href="login.php">Login</a></p>
               </div>
            </form>
         </div>
      </div>
   </div>
</body>
</html>
