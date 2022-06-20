<?php

@include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

session_start();

if (isset($_SESSION["user_id"])) {
   header('location: orders');
}
if (isset($_COOKIE["user_id"])) {
   header('location: orders');
}

if (isset($_COOKIE["admin"])) {
   header('location: admin/index');
}

if (isset($_POST["signin"])) {
   $email = mysqli_real_escape_string($conn, $_POST["email"]);
   $password = mysqli_real_escape_string($conn, md5($_POST["password"]));

   $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' AND password='$password' AND status='1'");
   $check_verification = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' AND password='$password' AND status='0'");

   if (mysqli_num_rows($check_email) > 0) {
      if(isset($_POST['remember'])){
         $row = mysqli_fetch_assoc($check_email);
         $username = $row['id'];
			setcookie('user_id',$username,time()+60*60*24*7);
         header("Location: index");
		} else{
         $row = mysqli_fetch_assoc($check_email);
         $_SESSION["user_id"] = $row['id'];
         header("Location: index");
		}
   } else if (mysqli_num_rows($check_verification) > 0) {
      $_SESSION['status'] = "Debes autentificar tu cuenta.";
      $_SESSION['status_msg'] = "error";
   } else {
      $_SESSION['status'] = "Credenciales incorrectas.";
      $_SESSION['status_msg'] = "error";
   } 

   $check_admin = mysqli_query($conn, "SELECT id FROM users WHERE email='$email' AND password='$password' AND status='1' AND user_type='1'");
   if (mysqli_num_rows($check_admin) > 0) {
      setcookie('user_id', $username, time() - 3600);
      session_unset();
      session_destroy();
      $row = mysqli_fetch_assoc($check_admin);
      $admin = $row['id'];
      setcookie('admin',$admin,time()+60*60*24*30);
      header("Location: admin/index");
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" href="src/logo.ico">
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
               <div class="form-group" id="checkbox_group">
                  <input class="checkbox" type="checkbox" value="Recordarme" name="remember">
                  <p>Mantener Sesión</p>
               </div>
               <div class="link forget-pass text-left"><a href="forgot-password">¿Contraseña olvidada?</a></div>
               <div class="form-group">
                  <input class="form-control button" type="submit" value="Inicio sesión" name="signin">
               </div>
               <div class="link login-link text-center"><p>¿Aún no eres miembro? <a href="register">Regístrate aquí</a></p></div>
            </form>
         </div>
      </div>
   </div>

  <script src="js/script.js"></script>

</body>

</html>

<?php
@include 'scripts/sweetalert.php';
?>