<?php

@include '../config.php';

session_start();

if (isset($_COOKIE["admin"])) {
   $admin = $_COOKIE['admin'];
}

if (!isset($admin)) {
   header('location: ../login');
};

if (isset($_POST['add_product'])) {

   $alter_table = mysqli_query($conn, "ALTER TABLE products AUTO_INCREMENT = 1") or die('query failed');

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $description = mysqli_real_escape_string($conn, $_POST['description']);
   $brand = mysqli_real_escape_string($conn, $_POST['get_brand']);
   $category = mysqli_real_escape_string($conn, $_POST['get_category']);
   $status = mysqli_real_escape_string($conn, $_POST['get_status']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../images/' . $image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

   if (mysqli_num_rows($select_product_name) > 0) {
      $_SESSION['status'] = "El nombre ya existe.";
      $_SESSION['status_msg'] = "error";
   } else {
      $insert_product = mysqli_query($conn, "INSERT INTO `products`(name, description, price, image, category, brand, status, date_add) VALUES('$name', '$description', '$price', 'images/$image', '$category', '$brand', '$status', NOW())") or die('query failed');

      if ($insert_product) {
         if ($image_size > 2000000) {
            $_SESSION['status'] = "El tamaño de la imagen es muy grande.";
            $_SESSION['status_msg'] = "error";
         } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $_SESSION['status'] = "Producto añadido.";
            $_SESSION['status_msg'] = "error";
         }
      }
   }
}

if (isset($_GET['delete'])) {

   $delete_id = $_GET['delete'];
   $select_delete = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete = mysqli_fetch_assoc($select_delete);
   unlink('uploaded_img/' . $fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `wishlist` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_products');
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" href="../src/logo.ico">
   <title>Productos</title>
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
         <h3 class="title">Añadir nuevo producto</h3>
         <input type="text" class="box" placeholder="Nombre" name="name" required>
         <input type="number" min="0" class="box" placeholder="Precio" name="price" step="any" required>
         <select name="get_brand" class="box">
            <?php
            $select_brands = mysqli_query($conn, "SELECT * FROM `brands`") or die('query failed');
            if (mysqli_num_rows($select_brands) > 0) {
               while ($fetch_brands = mysqli_fetch_assoc($select_brands)) {
            ?>
                  <option value="<?php echo $fetch_brands['id']; ?>"><?php echo $fetch_brands['name']; ?></option>
            <?php
               }
            }
            ?>
         </select>
         <select name="get_category" class="box">
            <?php
            $select_categories = mysqli_query($conn, "SELECT * FROM `categories`") or die('query failed');
            if (mysqli_num_rows($select_brands) > 0) {
               while ($fetch_categories = mysqli_fetch_assoc($select_categories)) {
            ?>
                  <option value="<?php echo $fetch_categories['id']; ?>"><?php echo $fetch_categories['name']; ?></option>
            <?php
               }
            }
            ?>
         </select>
         <select name="get_status" class="box">
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
         </select>
         <textarea name="description" class="box" placeholder="Descripción" cols="30" rows="10" required></textarea>
         <input type="file" accept="image/jpg, image/jpeg, image/png" class="box" name="image" required>
         <input type="submit" value="Añadir producto" name="add_product" class="btn">
      </form>

   </section>

   <section class="show-products">

      <div class="box-container">

         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
         ?>
               <div class="box">
                  <div class="price"><span><?php echo number_format($fetch_products['price'], 2, ',', '.'); ?>€</span></div>
                  <img class="image" src="../<?php echo $fetch_products['image']; ?>" alt="">
                  <div class="name"><?php echo $fetch_products['name']; ?></div>
                  <div class="description"><?php echo $fetch_products['description']; ?></div>
                  <a href="admin_update_product?update=<?php echo $fetch_products['id']; ?>" class="option-btn">Actualizar</a>
                  <a href="admin_products?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('¿Borrar este producto?');">Borrar</a>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">No hay productos aún.</p>';
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