<?php

@include '../config.php';

session_start();

if (isset($_COOKIE["admin"])) {
   $admin = $_COOKIE['admin'];
}

if (!isset($admin)) {
   header('location: ../login.php');
};

if (isset($_POST['add_category'])) {

   $alter_table = mysqli_query($conn, "ALTER TABLE categories AUTO_INCREMENT = 1") or die('query failed');

   $name = mysqli_real_escape_string($conn, $_POST['name']);

   $select_category_name = mysqli_query($conn, "SELECT name FROM `categories` WHERE name = '$name'") or die('query failed');

   if (mysqli_num_rows($select_category_name) > 0) {
      $_SESSION['status'] = "El nombre ya existe.";
      $_SESSION['status_msg'] = "error";
   } else {
      $insert_category = mysqli_query($conn, "INSERT INTO `categories`(name) VALUES('$name')") or die('query failed');
   }
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $select_delete_category = mysqli_query($conn, "DELETE FROM `categories` WHERE id = '$delete_id'") or die('query failed');
   header('location: admin_categories.php');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" href="../src/logo.ico">
   <title>Categorías</title>
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
         <h3 class="title">Añadir nueva categoría</h3>
         <input type="text" class="box" required placeholder="Introduce una nueva categoría" name="name">
         <input type="submit" value="Añadir Categoría" name="add_category" class="btn">
      </form>

   </section>

   <section class="show-products">

      <div class="box-container">

         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `categories`") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
         ?>
               <div class="box">
                  <div class="name">Id: <?php echo $fetch_products['id']; ?></div>
                  <div class="name">Nombre: <?php echo $fetch_products['name']; ?></div>
                  <a href="admin_categories.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('¿Borrar esta categoría?');">delete</a>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">No hay categorías aún.</p>';
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