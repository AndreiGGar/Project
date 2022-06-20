<?php

@include '../config.php';

session_start();

if (isset($_COOKIE["admin"])) {
   $admin = $_COOKIE['admin'];
}

if (!isset($admin)) {
   header('location: ../login.php');
};

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" href="../src/logo.ico">
   <title>Usuarios</title>
   <!-- bootstrap link  -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">

   <!-- font awesome link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- sweetalert link  -->
   <script src="js/sweetalert2.all.min.js"></script>

   <!-- jquery link  -->
   <script src="js/jquery-3.6.0.min.js"></script>

   <!-- css link  -->
   <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>

   <?php @include 'admin_header.php'; ?>

   <section class="users">

      <h1 class="title">Cuentas de Usuario</h1>

      <div class="box-container">
         <?php
         $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
         if (mysqli_num_rows($select_users) > 0) {
            while ($fetch_users = mysqli_fetch_assoc($select_users)) {
         ?>
               <div class="box">
                  <p>Id: <span><?php echo $fetch_users['id']; ?></span></p>
                  <p>Nombre: <span><?php echo $fetch_users['name']; ?></span></p>
                  <p>Email: <span><?php echo $fetch_users['email']; ?></span></p>
                  <p>Tipo de usuario: <span style="color:<?php if ($fetch_users['user_type'] == '1') {
                                                            echo 'var(--orange)';
                                                         };
                                                         if ($fetch_users['user_type'] == '2') {
                                                            echo 'var(--blue)';
                                                         }; ?>"><?php echo $fetch_users['user_type']; ?></span></p>
                  <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('¿Borrar este usuario?');" class="delete-btn">Borrar</a>
               </div>
         <?php
            }
         }
         ?>
      </div>

   </section>

   <script src="../js/script.js"></script>

</body>

</html>