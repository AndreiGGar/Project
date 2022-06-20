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

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:cart');
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart');
};

if (isset($_POST['update_quantity'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    $_SESSION['status'] = "Cantidad actualizada.";
    $_SESSION['status_msg'] = "success";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="src/logo.ico">
    <title>Carrito</title>
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
        <h3>Carrito de compras</h3>
        <p> <a href="index">Inicio</a> / Carrito </p>
    </section>

    <section class="shopping-cart">

        <h1 class="title">Productos:</h1>

        <div class="box-container">

            <?php
            $total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM `products` as a INNER JOIN `cart` as b WHERE a.id = b.product_id AND a.status = 1") or die('query failed');
            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            ?>
                    <div class="box">
                        <a href="cart?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
                        <a href="view_page?id=<?php echo $fetch_cart['id']; ?>" class="fas fa-eye"></a>
                        <img src="<?php echo $fetch_cart['image']; ?>" alt="" class="image">
                        <div class="name"><?php echo $fetch_cart['name']; ?></div>
                        <div class="price"><?php echo number_format($fetch_cart["price"], 2, ',', '.'); ?>€</div>
                        <form action="" method="post">
                            <input type="hidden" value="<?php echo $fetch_cart['id']; ?>" name="cart_id">
                            <input type="number" min="1" value="<?php echo $fetch_cart['quantity']; ?>" name="cart_quantity" class="qty">
                            <input type="submit" value="Actualizar" class="option-btn" name="update_quantity">
                        </form>
                        <div class="sub-total"> Subtotal: <span><?php $subtotal = ($fetch_cart['price'] * $fetch_cart['quantity']);
                                                                $final_subtotal = number_format($subtotal, 2, ',', '.');
                                                                echo $final_subtotal ?>€</span> </div>
                    </div>
            <?php
                    $total += $subtotal;
                }
            } else {
                echo '<p class="empty">El carrito está vacío</p>';
            }
            ?>
        </div>

        <div class="more-btn">
            <a href="cart?delete_all" class="another-btn <?php echo ($total > 1) ? '' : 'disabled' ?>" onclick="return confirm('¿Borrar del carrito?');">delete all</a>
        </div>

        <div class="cart-total">
            <p>Total: <span><?php $total = number_format($total, 2, ',', '.');
                            echo $total ?>€</span></p>
            <a href="shop" class="option-btn">Seguir comprando</a>
            <a href="checkout" class="btn  <?php echo ($total > 1) ? '' : 'disabled' ?>">Realizar pedido</a>
        </div>

    </section>

    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>

<?php
@include 'scripts/sweetalert.php';
?>