<?php

@include 'config.php';

session_start();

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_COOKIE["user_id"])) {
    $user_id = $_COOKIE['user_id'];
}

if (isset($_POST['add_to_wishlist']) && !isset($_COOKIE['admin'])) {

    if (!isset($user_id)) {
        header('location:login.php');
    };

    $product_id = $_POST['product_id'];

    $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE product_id = '$product_id' AND user_id = '$user_id'") or die('query failed');

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE product_id = '$product_id' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_wishlist_numbers) > 0) {
        $_SESSION['status'] = "Producto ya añadido a la lista de deseados.";
        $_SESSION['status_msg'] = "error";
    } elseif (mysqli_num_rows($check_cart_numbers) > 0) {
        $_SESSION['status'] = "Producto ya añadido al carrito.";
        $_SESSION['status_msg'] = "error";
    } else {
        mysqli_query($conn, "INSERT INTO `wishlist`(user_id, product_id) VALUES('$user_id', '$product_id')") or die('query failed');
        $_SESSION['status'] = "Producto añadido a la lista de deseados.";
        $_SESSION['status_msg'] = "success";
    }
}

if (isset($_POST['add_to_cart']) && !isset($_COOKIE['admin'])) {

    if (!isset($user_id)) {
        header('location:login.php');
    };

    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE product_id = '$product_id' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $_SESSION['status'] = "Producto ya añadido al carrito de compras.";
        $_SESSION['status_msg'] = "error";
    } else {

        $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE product_id = '$product_id' AND user_id = '$user_id'") or die('query failed');

        if (mysqli_num_rows($check_wishlist_numbers) > 0) {
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE product_id = '$product_id' AND user_id = '$user_id'") or die('query failed');
        }

        mysqli_query($conn, "INSERT INTO `cart`(user_id, product_id, quantity) VALUES('$user_id', '$product_id', '$product_quantity')") or die('query failed');
        $_SESSION['status'] = "Producto añadido al carrito de compras.";
        $_SESSION['status_msg'] = "success";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="src/logo.ico">
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
            <h1 class="title">Promociones</h1>
            <p>Si buscas las mejores ofertas tecnológicas, sin duda, esta es tu página. Buscamos ofrecerte siempre los mejores productos al mejor precio, calidad garantizada.</p>
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
                        <a href="view_page.php?id=<?php echo $row['id']; ?>" class="fas fa-eye"></a>
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
                echo '<p class="empty">¡No hay productos aún!</p>';
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

    <section class="newsletter">

        <div class="content">
            <h3>Newsletter</h3>
            <p>Suscríbete ya a nuestro newsletter y no te pierdas ninguna novedad. Además recibirás numerosos descuentos, sorteos... ¿a qué esperas?</p>
            <form>
                <input type="text" name="newletter"></input>
                <button type="submit" class="btn-news" name="send">Enviar</button>
            </form>
        </div>

    </section>

    <div class="wrapper">
        <img src="src/cookie.png" alt="">
        <div class="content">
            <header>Consentimiento Cookies</header>
            <p>Esta página usa cookies para otorgar la mejor experiencia a cada usuario.</p>
            <div class="buttons">
                <button class="item">Aceptar</button>
                <a href="#" class="item">Ver más acerca</a>
            </div>
        </div>
    </div>

    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>
    <script src="js/cookie.js"></script>

</body>

</html>

<?php
@include 'scripts/sweetalert.php';
?>