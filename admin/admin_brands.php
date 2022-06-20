<?php

@include '../config.php';

session_start();

if (isset($_COOKIE["admin"])) {
   $admin = $_COOKIE['admin'];
}

if (!isset($admin)) {
   header('location: ../login.php');
};

if (isset($_POST['add_brand'])) {

   $alter_table = mysqli_query($conn, "ALTER TABLE brands AUTO_INCREMENT = 1") or die('query failed');

   $name = mysqli_real_escape_string($conn, $_POST['name']);

   $select_brand_name = mysqli_query($conn, "SELECT name FROM `brands` WHERE name = '$name'") or die('query failed');

   if (mysqli_num_rows($select_brand_name) > 0) {
      $_SESSION['status'] = "El nombre ya existe.";
      $_SESSION['status_msg'] = "error";
   } else {
      $insert_brand = mysqli_query($conn, "INSERT INTO `brands`(name) VALUES('$name')") or die('query failed');
   }
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $select_delete_brand = mysqli_query($conn, "DELETE FROM `brands` WHERE id = '$delete_id'") or die('query failed');
   header('location: admin_brands.php');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" href="../src/logo.ico">
   <title>Marcas</title>
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

   <section class="add-products">

      <form action="" method="POST" enctype="multipart/form-data">
         <h3 class="title">Añadir nueva marca</h3>
         <input type="text" class="box" required placeholder="Introduce una nueva marca" name="name">
         <input type="submit" value="Añadir Categoría" name="add_brand" class="btn">
      </form>

   </section>

   <section class="show-products">

      <div class="box-container">

         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `brands`") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
         ?>
               <div class="box">
                  <div class="name">Id: <?php echo $fetch_products['id']; ?></div>
                  <div class="name">Nombre: <?php echo $fetch_products['name']; ?></div>
                  <a href="admin_brands.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('¿Borrar esta marca?');">delete</a>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">No hay marcas aún.</p>';
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