<?php

@include '../config.php';

session_start();

if (isset($_COOKIE["admin"])) {
   $admin = $_COOKIE['admin'];
}

if (!isset($admin)) {
   header('location: ../login');
};

if (isset($_POST['update_product'])) {

   $update_p_id = $_POST['update_p_id'];
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $description = mysqli_real_escape_string($conn, $_POST['description']);
   $brand = mysqli_real_escape_string($conn, $_POST['get_brand']);
   $category = mysqli_real_escape_string($conn, $_POST['get_category']);
   $status = mysqli_real_escape_string($conn, $_POST['get_status']);

   mysqli_query($conn, "UPDATE `products` SET name = '$name', description = '$description', price = '$price', brand = '$brand', category = '$category', status = '$status' WHERE id = '$update_p_id'") or die('query failed');

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = '../images/' . $image;
   $old_image = $_POST['update_p_image'];

   if (!empty($image)) {
      if ($image_size > 2000000) {
         $_SESSION['status'] = "El tamaño de la imagen es muy grande.";
         $_SESSION['status_msg'] = "error";
      } else {
         mysqli_query($conn, "UPDATE `products` SET image = 'images/$image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($image_tmp_name, $image_folter);
         // unlink('../images/'.$old_image);
         $_SESSION['status'] = "Imagen actualizada.";
         $_SESSION['status_msg'] = "success";
      }
   }

   $_SESSION['status'] = "Producto actualizado.";
   $_SESSION['status_msg'] = "success";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" href="../src/logo.ico">
   <title>Actualizar producto</title>
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

   <section class="update-product">

      <?php

      $update_id = $_GET['update'];
      $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
      if (mysqli_num_rows($select_products) > 0) {
         while ($fetch_products = mysqli_fetch_assoc($select_products)) {
      ?>

            <form action="" method="post" enctype="multipart/form-data">
               <img src="../<?php echo $fetch_products['image']; ?>" class="image" alt="">
               <input type="hidden" value="<?php echo $fetch_products['id']; ?>" name="update_p_id">
               <input type="hidden" value="<?php echo $fetch_products['image']; ?>" name="update_p_image">
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
               <input type="text" class="box" value="<?php echo $fetch_products['name']; ?>" required placeholder="Nombre" name="name">
               <input type="number" step="any" min="0" class="box" value="<?php echo $fetch_products['price']; ?>" required placeholder="Precio" name="price">
               <textarea name="description" class="box" required placeholder="Descripción" cols="30" rows="10"><?php echo $fetch_products['description']; ?></textarea>
               <input type="file" accept="image/jpg, image/jpeg, image/png" class="box" name="image">
               <a href="admin_products" class="option-btn">Volver</a>
               <input type="submit" value="Actualizar producto" name="update_product" class="btn">
            </form>

      <?php
         }
      } else {
         echo '<p class="empty">no update product select</p>';
      }
      ?>

   </section>
   
   <script src="../js/script.js"></script>

</body>

</html>

<?php
@include '../scripts/sweetalert.php';
?>