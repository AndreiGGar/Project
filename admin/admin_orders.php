<?php

@include '../config.php';

session_start();

$disabled = '';

if (isset($_COOKIE["admin"])) {
   $admin = $_COOKIE['admin'];
}

if (!isset($admin)) {
   header('location: ../login.php');
};

if (isset($_POST['update_order'])) {
   $order_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_id'") or die('query failed');
   $_SESSION['status'] = "El estado ha sido actualizado.";
   $_SESSION['status_msg'] = "success";
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" href="../src/logo.ico">
   <title>Pedidos</title>
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

   <section class="placed-orders">

      <h1 class="title">Pedidos</h1>

      <div class="box-container">

         <?php

         $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
         if (mysqli_num_rows($select_orders) > 0) {
            while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
               if ($fetch_orders['payment_status'] == 'completado' or $fetch_orders['payment_status'] == 'cancelado') {
                  $disabled = 'disabled';
               } else {
                  $disabled = '';
               }
         ?>
               <div class="box">
                  <p> Id: <span><?php echo $fetch_orders['id']; ?></span> </p>
                  <p> Fecha pedido: <span><?php echo $fetch_orders['app_date']; ?></span> </p>
                  <p> Usuario: <span><?php echo $fetch_orders['user_id']; ?></span> </p>
                  <p> Dirección: <span><?php echo $fetch_orders['place']; ?></span> </p>
                  <p> Método de pago: <span><?php echo $fetch_orders['method']; ?></span> </p>
                  <p> Tus órdenes: <span><?php echo $fetch_orders['total_products']; ?></span> </p>
                  <p> Precio total: <span><?php echo number_format($fetch_orders['total_price'], 2, ',', '.'); ?>€</span> </p>
                  <form action="" method="post">
                     <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                     <select name="update_payment">
                        <option disabled selected><?php echo $fetch_orders['payment_status']; ?></option>
                        <option value="pendiente" <?php echo $disabled; ?>>pendiente</option>
                        <option value="completado" <?php echo $disabled; ?>>completado</option>
                        <option value="cancelado" <?php echo $disabled; ?>>cancelado</option>
                     </select>
                     <input type="submit" name="update_order" value="update" class="option-btn">
                     <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('¿Borrar este pedido?');">Borrar</a>
                  </form>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">No hay pedidos aún.</p>';
         }
         ?>
      </div>

   </section>

   <script src="../js/script.js"></script>

</body>

</html>

<?php
@include '../scripts/sweetalert.php';
?>