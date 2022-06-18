<?php

@include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

session_start();

// if (isset($_POST['submit'])) {

//    $filter_name = filter_var($_POST['name']);
//    $name = mysqli_real_escape_string($conn, $filter_name);
//    $filter_email = filter_var($_POST['email']);
//    $email = mysqli_real_escape_string($conn, $filter_email);
//    $filter_pass = filter_var($_POST['pass']);
//    $pass = mysqli_real_escape_string($conn, md5($filter_pass));
//    $filter_cpass = filter_var($_POST['cpass']);
//    $cpass = mysqli_real_escape_string($conn, md5($filter_cpass));

//    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

//    if (mysqli_num_rows($select_users) > 0) {
//       $message[] = 'El usuario ya existe.';
//    } else {
//       if ($pass != $cpass) {
//          $message[] = 'Las contraseñas no coinciden.';
//       } else {
//          mysqli_query($conn, "INSERT INTO `users`(name, email, password) VALUES('$name', '$email', '$pass')") or die('query failed');
//          $message[] = '¡Te has registrado con éxito!';
//          header('location: login.php');
//       }
//    }
// }

if (isset($_POST["signup"])) {
   $full_name = mysqli_real_escape_string($conn, $_POST["signup_full_name"]);
   $email = mysqli_real_escape_string($conn, $_POST["signup_email"]);
   $password = mysqli_real_escape_string($conn, md5($_POST["signup_password"]));
   $cpassword = mysqli_real_escape_string($conn, md5($_POST["signup_cpassword"]));
   $token = md5(rand());

   $check_email = mysqli_num_rows(mysqli_query($conn, "SELECT email FROM users WHERE email='$email'"));

   if ($password !== $cpassword) {
      $_SESSION['status'] = "Las contraseñas no coinciden.";
      $_SESSION['status_msg'] = "error";
   } elseif ($check_email > 0) {
      $_SESSION['status'] = "El email ya está registrado.";
      $_SESSION['status_msg'] = "error";
   } else {
      $sql = "INSERT INTO users (`name`, `email`, `password`, `token`, `user-type`, `status`, `date-add`) VALUES ('$full_name', '$email', '$password', '$token', '2', '0', now())";
      $result = mysqli_query($conn, $sql);
      if ($result) {
         $_POST["signup_full_name"] = "";
         $_POST["signup_email"] = "";
         $_POST["signup_password"] = "";
         $_POST["signup_cpassword"] = "";

         $to = $email;
         $subject = "Verificar Email - Phoenix Comps";
         $message = "
            <html>
            <head>
            <title>{$subject}</title>
            </head>
            <body>
            <p><strong>Estimado {$full_name},</strong></p>
            <p>¡Gracias por registrarte!</p>
            <P>Solo te queda un sencillo paso. Haz click al siguiente enlace para verificar tu cuenta.</p>
            <p><a href='{$base_url}verify-email.php?token={$token}'>Verificar Cuenta</a></p>
            <img src='cid:logo';
            </body>
            </html>
         ";

         //Create an instance; passing `true` enables exceptions
         $mail = new PHPMailer(true);

         try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $smtp['host'];                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $smtp['user'];                     //SMTP username
            $mail->Password   = $smtp['pass'];                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = $smtp['port'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($my_email);
            $mail->addAddress($email, $full_name);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->addEmbeddedImage('src/logo-small.png', 'logo', 'PhoenixComps');

            $mail->send();
            header("Location: login.php");
            $_SESSION['status'] = "Hemos enviado un link de confirmación a tu correo: " . $email . ".";
            $_SESSION['status_msg'] = "success";
         } catch (Exception $e) {
            $_SESSION['status'] = "Correo no enviado. Inténtelo de nuevo.";
            $_SESSION['status_msg'] = "error";
         }
      } else {
         $_SESSION['status'] = "El registro ha fallado.";
         $_SESSION['status_msg'] = "error";
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
   <title>Registro</title>
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

   <div class="container register">
      <div class="row">
         <div class="col-md-6 offset-md-3 form register-form">
            <form action="" method="post" class="sign-up-form">
               <h2 class="title">Regístrate</h2>
               <h2 class="text-center">Regístrate ya con tu nombre, correo y contraseña</h2>
               <div class="input-field">
                  <i class="fas fa-user"></i>
                  <input type="text" placeholder="Nombre" name="signup_full_name" required />
               </div>
               <div class="input-field">
                  <i class="fas fa-envelope"></i>
                  <input type="email" placeholder="Correo" name="signup_email" required />
               </div>
               <div class="input-field">
                  <i class="fas fa-lock"></i>
                  <input type="password" placeholder="Contraseña" name="signup_password" required />
               </div>
               <div class="input-field">
                  <i class="fas fa-lock"></i>
                  <input type="password" placeholder="Confirmar contraseña" name="signup_cpassword" required />
               </div>
               <div class="form-group">
                  <input class="form-control button" type="submit" value="Registro" name="signup">
               </div>
               <div class="link login-link text-center">
                  <p>Ya eres miembro? <a href="login.php">Inicia sesión aquí</a></p>
               </div>
            </form>
         </div>
      </div>
   </div>

</body>

</html>

<?php
@include 'scripts/sweetalert.php';
?>