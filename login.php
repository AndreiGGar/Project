<?php

@include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

session_start();

// if(isset($_SESSION['user_id'])){
//    header('location:index.php');
// }

// if (isset($_POST['submit'])) {

//    $filter_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
//    $email = mysqli_real_escape_string($conn, $filter_email);
//    $filter_pass = filter_var($_POST['pass']);
//    $pass = mysqli_real_escape_string($conn, md5($filter_pass));

//    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');


//    if (mysqli_num_rows($select_users) > 0) {

//       $row = mysqli_fetch_assoc($select_users);

//       if ($row['user_type'] == 'admin') {

//          $_SESSION['admin_name'] = $row['name'];
//          $_SESSION['admin_email'] = $row['email'];
//          $_SESSION['admin_id'] = $row['id'];
//          header('location:admin_page.php');
//       } elseif ($row['user_type'] == 'user') {

//          $_SESSION['user_name'] = $row['name'];
//          $_SESSION['user_email'] = $row['email'];
//          $_SESSION['user_id'] = $row['id'];
//          header('location:index.php');
//       } else {
//          $message[] = 'Usuario no encontrado.';
//       }
//    } else {
//       $message[] = 'Email o contraseña incorrecta.';
//    }
// }

if (isset($_SESSION["user_id"])) {
   header("Location: index.php");
}

if (isset($_POST["signin"])) {
   $email = mysqli_real_escape_string($conn, $_POST["email"]);
   $password = mysqli_real_escape_string($conn, md5($_POST["password"]));

   $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' AND password='$password' AND status='1'");
   $check_email2 = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' AND password='$password' AND status='0'");

   if (mysqli_num_rows($check_email) > 0) {
      $row = mysqli_fetch_assoc($check_email);
      $_SESSION["user_id"] = $row['id'];
      header("Location: index.php");
   } else if (mysqli_num_rows($check_email2) > 0) {
      $_SESSION['status'] = "Debes autentificar tu cuenta.";
      $_SESSION['status_msg'] = "error";
   } else {
      $_SESSION['status'] = "Credenciales incorrectas.";
      $_SESSION['status_msg'] = "error";
   } 
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Iniciar sesión</title>
   <!-- bootstrap link  -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">

   <!-- font awesome link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- sweetalert link  -->
   <script src="js/sweetalert2.all.min.js"></script>

   <!-- jquery link  -->
   <script src="js/jquery-3.6.0.min.js"></script>

   <!-- css link  -->
   <link rel="stylesheet" href="css/style.css">
</head>

<body>

   <div class="container login">
      <div class="row">
         <div class="col-md-6 offset-md-3 form login-form">
            <form action="" method="post" class="sign-in-form">
               <h2 class="title">Inicia sesión</h2>
               <h2 class="text-center">Inicia sesión con tu correo y contraseña</h2>
               <div class="input-field">
                  <i class="fas fa-user"></i>
                  <input type="text" placeholder="Email" name="email" required />
               </div>
               <div class="input-field">
                  <i class="fas fa-lock"></i>
                  <input type="password" placeholder="Contraseña" name="password" required />
               </div>
               <div class="link forget-pass text-left"><a href="forgot-password.php">¿Contraseña olvidada?</a></div>
               <div class="form-group">
                  <input class="form-control button" type="submit" value="Inicio sesión" name="signin">
               </div>
               <div class="link login-link text-center"><p>¿Aún no eres miembro? <a href="register.php">Regístrate aquí</a></p></div>
            </form>
         </div>
      </div>
   </div>

</body>

</html>

<?php
@include 'scripts/sweetalert.php';
?>