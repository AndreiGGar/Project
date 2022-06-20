<?php

@include 'config.php';

session_start();

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_COOKIE["user_id"])) {
    $user_id = $_COOKIE['user_id'];
}

if (!isset($user_id)) {
    header('location:login');
};

if (isset($_POST['add_to_cart'])) {

    if (!isset($user_id)) {
        header('location:login');
    };

    $product_id = $_POST['product_id'];
    $product_quantity = 1;

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

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE id = '$delete_id'") or die('query failed');
    header('location: wishlist');
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
    header('location: wishlist');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Deseados</title>
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

    <section class="heading">
        <h3>Lista de productos deseados</h3>
        <p> <a href="index">Inicio</a> / Productos Deseados </p>
    </section>

    <section class="wishlist">

        <h1 class="title">Productos: </h1>

        <div class="box-container">

            <?php
            $grand_total = 0;
            $select_wishlist = mysqli_query($conn, "SELECT *, b.id as id FROM `products` as a INNER JOIN `wishlist` as b WHERE a.id = b.product_id AND a.status = 1") or die('query failed');
            if (mysqli_num_rows($select_wishlist) > 0) {
                while ($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)) {
            ?>
                    <form action="" method="POST" class="box">
                        <a href="wishlist?delete=<?php echo $fetch_wishlist['id']; ?>" class="fas fa-times" onclick="return confirm('¿Borrar de la lista de deseados?');"></a>
                        <a href="view_page?id=<?php echo $fetch_wishlist['id']; ?>" class="fas fa-eye"></a>
                        <img src="<?php echo $fetch_wishlist['image']; ?>" alt="" class="image">
                        <div class="name"><?php echo $fetch_wishlist['name']; ?></div>
                        <div class="price"><?php echo number_format($fetch_wishlist["price"], 2, ',', '.'); ?>€</div>
                        <input type="hidden" name="product_id" value="<?php echo $fetch_wishlist['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_wishlist['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_wishlist['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_wishlist['image']; ?>">
                        <input type="submit" value="Añadir al Carrito" name="add_to_cart" class="btn">
                    </form>
            <?php
                    $grand_total += $fetch_wishlist['price'];
                }
            } else {
                echo '<p class="empty">La lista esta vacía</p>';
            }
            ?>
        </div>

        <div class="wishlist-total">
            <a href="shop" class="option-btn">Seguir Comprando</a>
            <a href="wishlist?delete_all" class="another-btn <?php echo ($grand_total > 1) ? '' : 'disabled' ?>" onclick="return confirm('¿Quitar todos los productos de la lista?');">Borrar toda la lista</a>
        </div>

    </section>

    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>

<?php
@include 'scripts/sweetalert.php';
?>