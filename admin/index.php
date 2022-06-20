<?php

@include '../config.php';

session_start();

if (isset($_COOKIE["admin"])) {
   $admin = $_COOKIE['admin'];
}

if (!isset($admin)) {
   header('location: ../login.php');
};

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" href="../src/logo.ico">
   <title>Dashboard</title>
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

   <section class="dashboard">

      <h1 class="title">Dashboard</h1>

      <div class="box-container">

         <div class="box">
            <?php
            $total_pendings = 0;
            $select_pendings = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
            while ($fetch_pendings = mysqli_fetch_assoc($select_pendings)) {
               $total_pendings += $fetch_pendings['total_price'];
            };
            ?>
            <h3><?php echo number_format($total_pendings, 2, ',', '.'); ?>€</h3>
            <p>Total pendientes</p>
         </div>

         <div class="box">
            <?php
            $total_completes = 0;
            $select_completes = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
            while ($fetch_completes = mysqli_fetch_assoc($select_completes)) {
               $total_completes += $fetch_completes['total_price'];
            };
            ?>
            <h3><?php echo number_format($total_completes, 2, ',', '.'); ?>€</h3>
            <p>Total completados</p>
         </div>

         <div class="box">
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
            ?>
            <h3><?php echo $number_of_orders; ?></h3>
            <p>Pedidos realizados</p>
         </div>

         <div class="box">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            $number_of_products = mysqli_num_rows($select_products);
            ?>
            <h3><?php echo $number_of_products; ?></h3>
            <p>Productos añadidos</p>
         </div>

         <div class="box">
            <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = '2' AND status='1'") or die('query failed');
            $number_of_users = mysqli_num_rows($select_users);
            ?>
            <h3><?php echo $number_of_users; ?></h3>
            <p>Usuarios</p>
         </div>

         <div class="box">
            <?php
            $select_admin = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = '1' AND status='1'") or die('query failed');
            $number_of_admin = mysqli_num_rows($select_admin);
            ?>
            <h3><?php echo $number_of_admin; ?></h3>
            <p>Administradores</p>
         </div>

         <div class="box">
            <?php
            $select_account = mysqli_query($conn, "SELECT * FROM `users` WHERE status='1'") or die('query failed');
            $number_of_account = mysqli_num_rows($select_account);
            ?>
            <h3><?php echo $number_of_account; ?></h3>
            <p>Total cuentas</p>
         </div>

         <div class="box">
            <?php
            $select_account = mysqli_query($conn, "SELECT * FROM `users` WHERE status='0'") or die('query failed');
            $select_account_total = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            $number_of_account = mysqli_num_rows($select_account);
            $number_of_account_total = mysqli_num_rows($select_account_total);
            ?>
            <h3><?php echo $number_of_account; ?> / <?php echo $number_of_account_total; ?></h3>
            <p>Cuentas no verificadas</p>
         </div>

         <div class="box">
            <?php
            $select_messages = mysqli_query($conn, "SELECT * FROM `messages`") or die('query failed');
            $number_of_messages = mysqli_num_rows($select_messages);
            ?>
            <h3><?php echo $number_of_messages; ?></h3>
            <p>Mensajes</p>
         </div>

         <div class="box">
            <?php
            $select_messages = mysqli_query($conn, "SELECT * FROM `categories`") or die('query failed');
            $number_of_messages = mysqli_num_rows($select_messages);
            ?>
            <h3><?php echo $number_of_messages; ?></h3>
            <p>Categorías</p>
         </div>
         <div class="box">
            <?php
            $select_messages = mysqli_query($conn, "SELECT * FROM `brands`") or die('query failed');
            $number_of_messages = mysqli_num_rows($select_messages);
            ?>
            <h3><?php echo $number_of_messages; ?></h3>
            <p>Marcas</p>
         </div>

      </div>

   </section>

   <script src="../js/script.js"></script>

</body>

</html>