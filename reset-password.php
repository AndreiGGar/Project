<?php

include 'config.php';

error_reporting(0);

session_start();

if (isset($_SESSION["user_id"])) {
  header("Location: index.php");
}

if (isset($_POST["resetPassword"])) {
  $password = mysqli_real_escape_string($conn, md5($_POST["new_password"]));
  $cpassword = mysqli_real_escape_string($conn, md5($_POST["cnew_password"]));
  if ($password === $cpassword) {
    $sql = "UPDATE users SET password='$password' WHERE token='{$_GET["token"]}'";
    mysqli_query($conn, $sql);
    $_SESSION['status'] = "La contraseña se restableció correctamente.";
    $_SESSION['status_msg'] = "error";
    header("Location: index.php");
  } else {
    $_SESSION['status'] = "Las contraseñas no coinciden.";
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
  <title>Restablecimiento Contraseña</title>
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

  <div class="container reset">
    <div class="row">
      <div class="col-md-6 offset-md-3 form reset-form">
        <form action="" method="post" class="sign-in-form">
          <h2 class="title">Restablecimiento de Contraseña</h2>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Nueva contraseña" name="new_password" value="<?php echo $_POST['new_password']; ?>" required />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirmar nueva contraseña" name="cnew_password" value="<?php echo $_POST['cnew_password']; ?>" required />
          </div>
          <input type="submit" value="Reset Password" name="resetPassword" class="btn solid">
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