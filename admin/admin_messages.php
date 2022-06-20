<?php

@include '../config.php';

session_start();

if (isset($_COOKIE["admin"])) {
   $admin = $_COOKIE['admin'];
}

if (!isset($admin)) {
   header('location: ../login');
};

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `messages` WHERE id = '$delete_id'") or die('query failed');
   header('location: admin_messages');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" href="../src/logo.ico">
   <title>Mensajes</title>
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

   <section class="messages">

      <h1 class="title">Mensajes</h1>

      <div class="box-container">

         <?php
         $select_message = mysqli_query($conn, "SELECT * FROM `messages`") or die('query failed');
         if (mysqli_num_rows($select_message) > 0) {
            while ($fetch_message = mysqli_fetch_assoc($select_message)) {
         ?>
               <div class="box">
                  <p>Id: <span><?php echo $fetch_message['id']; ?></span> </p>
                  <p>Nombre: <span><?php echo $fetch_message['name']; ?></span> </p>
                  <p>Número: <span><?php echo $fetch_message['number']; ?></span> </p>
                  <p>Email: <span><?php echo $fetch_message['email']; ?></span> </p>
                  <p>Mensaje: <span><?php echo $fetch_message['description']; ?></span> </p>
                  <a href="admin_messages?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('¿Borrar este mensaje?');" class="delete-btn">Borrar</a>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">No hay mensajes.</p>';
         }
         ?>
      </div>

      <script src="../js/script.js"></script>

</body>

</html>