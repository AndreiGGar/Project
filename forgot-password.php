<?php

include 'config.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

session_start();

error_reporting(0);

if (isset($_SESSION["user_id"])) {
  header("Location: index.php");
}

if (isset($_POST["resetPassword"])) {
  $email = mysqli_real_escape_string($conn, $_POST["email"]);

  $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

  if (mysqli_num_rows($check_email) > 0) {
    $data = mysqli_fetch_assoc($check_email);

    $to = $email;
    $subject = "Restablecer Clave - Phoenix Comps";

    $message = "
      <html>
      <head>
      <title>{$subject}</title>
      </head>
      <body>
      <p><strong>Estimado {$data['full_name']},</strong></p>
      <p>¿Te has olvidado de la contraseña? No hay ningún problema. Haz click al siguiente enlace para restablecer tu contraseña.</p>
      <p><a href='{$base_url}reset-password.php?token={$data['token']}'>Reset Password</a></p>
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
      $mail->addAddress($email, $data['full_name']);     //Add a recipient

      //Content
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = $subject;
      $mail->Body    = $message;
      $mail->addEmbeddedImage('src/logo-small.png', 'logo', 'PhoenixComps');

      $mail->send();
      $_SESSION['status'] = "Hemos enviado un link de restablecimiento a tu correo: " . $email . ".";
      $_SESSION['status_msg'] = "success";
    } catch (Exception $e) {
      $_SESSION['status'] = "Correo no enviado. Inténtelo de nuevo.";
      $_SESSION['status_msg'] = "error";
    }
  } else {
    $_SESSION['status'] = "Email no encontrado.";
    $_SESSION['status_msg'] = "error";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="src/logo.ico">
  <title>Restablecer Contraseña</title>
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

  <div class="container forgot">
    <div class="row">
      <div class="col-md-6 offset-md-3 form forgot-form">
        <form action="" method="post" class="sign-in-form">
          <h2 class="title">Restablecer Contraseña</h2>
          <h2 class="text-center">Se te enviará un mensaje de restablecimiento.</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Email" name="email" required />
          </div>
          <input class="form-control button" type="submit" value="Restablecer Contraseña" name="resetPassword">
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