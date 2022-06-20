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
        header('location:login');
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
        header('location:login');
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
    <title>Detalle Producto</title>
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

    <section class="quick-view">

        <h1 class="title">Detalle producto</h1>

        <?php
        if (isset($_GET['id'])) {
            $pid = $_GET['id'];
            $select_products = mysqli_query($conn, "SELECT *, a.name as name, b.name as brandname, c.name as categoryname FROM `products` as A INNER JOIN `brands` as b INNER JOIN `categories` as c WHERE a.brand = b.id AND a.category = c.id AND a.status = 1 AND a.id = $pid") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>
                    <form action="" method="POST">
                        <img src="<?php echo $fetch_products['image']; ?>" alt="" class="image">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <div class="price"><?php echo number_format($fetch_products["price"], 2, ',', '.'); ?>€</div>
                        <div class="description"><?php echo $fetch_products['description']; ?></div>
                        <div class="details">Marca: <?php echo $fetch_products['brandname']; ?></div>
                        <div class="details">Categoría: <?php echo $fetch_products['categoryname']; ?></div>
                        <input type="number" name="product_quantity" value="1" min="1" class="qty">
                        <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                        <div class="row d-flex justify-content-center">
                            <input type="submit" value="Añadir a Deseados" name="add_to_wishlist" class="option-btn">
                        </div>
                        <div class="row d-flex justify-content-center">
                            <input type="submit" value="Añadir al Carrito" name="add_to_cart" class="btn">
                        </div>
                    </form>
        <?php
                }
            } else {
                echo '<p class="empty">no products details available!</p>';
            }
        }
        ?>

        <div class="more-btn">
            <button onclick="history.go(-1)" class="another-btn">Volver atrás</button>
        </div>

    </section>

    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>

<?php
@include 'scripts/sweetalert.php';
?>