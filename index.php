<?php

@include 'config.php';

session_start();

/*
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if (isset($_POST['add_to_wishlist'])) {

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_wishlist_numbers) > 0) {
        $message[] = 'Ya fue añadido a la lista de productos deseados';
    } else {
        mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
        $message[] = 'Producto añadido a la lista de productos deseados';
    }
}
*/

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="src/logo.ico" />
    <title>PhoenixComps</title>
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

    <?php @include 'header.php'; ?>

    <section class="home">

        <div class="content">
            <h3>Promociones</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime reiciendis, modi placeat sit cumque molestiae.</p>
            <a href="shop.php" class="btn">Descubre más</a>
        </div>

    </section>

    <section class="products">

        <h1 class="title">Últimos productos</h1>

        <div class="box-container">

            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 3") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($row = mysqli_fetch_assoc($select_products)) {
            ?>
                    <form action="" method="POST" class="box">
                        <a href="view_page.php?pid=<?php echo $row['id']; ?>" class="fas fa-eye"></a>
                        <div class="price"><?php echo number_format($row["price"], 2, ',', '.'); ?>€</div>
                        <img src="<?php echo $row['image']; ?>" alt="" class="image">
                        <div class="name"><?php echo $row['name']; ?></div>
                        <input type="number" name="product_quantity" value="1" min="0" class="qty">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $row['description']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
                        <input type="submit" value="Añadir a Deseados" name="add_to_wishlist" class="option-btn">
                        <input type="submit" value="Añadir al Carrito" name="add_to_cart" class="btn">
                    </form>
            <?php
                }
            } else {
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>

        </div>

        <div class="more-btn">
            <a href="shop.php" class="another-btn">Cargar más</a>
        </div>

    </section>

    <section class="home-contact">

        <div class="content">
            <h3>¿Tienes preguntas?</h3>
            <p>Si te has quedado con dudas puedes contactar a nuestro gran equipo hasta quedar satisfecho sin ningún compromiso.</p>
            <a href="contact.php" class="btn">Contacto</a>
        </div>

    </section>

    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>