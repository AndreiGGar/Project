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
    header('location:login.php');
};

if (isset($_POST['order'])) {

    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, $_POST['flat'] . ', ' . $_POST['location'] . ', ' . $_POST['city'] . ' - ' . $_POST['pin_code']);

    $cart_total = 0;
    $cart_products = [];

    $cart_query = mysqli_query($conn, "SELECT * FROM `products` as a INNER JOIN `cart` as b WHERE a.id = b.product_id AND a.status = 1 AND $user_id = b.user_id") or die('query failed');
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ')';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }
    $total_products = implode('; ', $cart_products);

    if ($cart_total == 0) {
        $_SESSION['status'] = "El carrito está vacío.";
        $_SESSION['status_msg'] = "error";
    } else {
        mysqli_query($conn, "INSERT INTO `orders`(user_id, total_products, total_price, method, place, payment_status, app_date) VALUES('$user_id', '$total_products', '$cart_total', '$method', '$address', 'pendiente', NOW())") or die('query failed');
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        $_SESSION['status'] = "Pedido realizado correctamente.";
        $_SESSION['status_msg'] = "success";
    }
}

$user_query = mysqli_query($conn, "SELECT email FROM `users` WHERE id = $user_id") or die('query failed');
$row = mysqli_fetch_assoc($user_query);
$user = $row['email'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="src/logo.ico">
    <title>checkout</title>
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
        <h3>Pedido</h3>
        <p> <a href="home.php">Inicio</a> / Pedido </p>
    </section>

    <section class="display-order">
        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `products` as a INNER JOIN `cart` as b WHERE a.id = b.product_id AND a.status = 1 AND $user_id = b.user_id") or die('query failed');
        if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                $final_total = number_format($total_price, 2, ',', '.');
                $grand_total += $total_price;
        ?>
                <p> <?php echo $fetch_cart['name'] ?> <span>(<?php echo number_format($fetch_cart['price'], 2, ',', '.') . '€ /' . ' x' . $fetch_cart['quantity']  ?>)</span> </p>
        <?php
            }
        } else {
            echo '<p class="empty">El carrito está vacío</p>';
        }
        ?>
        <div class="grand-total">Total: <span><?php $grand_total = number_format($grand_total, 2, ',', '.');
                                                echo $grand_total ?>€</span></div>
    </section>

    <section class="checkout">

        <form action="" method="POST">

            <h3>Confirma tu pedido</h3>

            <div class="flex">
                <div class="inputBox">
                    <span>Cuenta:</span>
                    <input type="text" name="name" disabled="disabled" value="<?php echo $user; ?>">
                </div>
                <div class="inputBox">
                    <span>Método de pago:</span>
                    <select name="method">
                        <option value="Tarjeta de crédito">Tarjeta de crédito</option>
                        <option value="Tarjeta de débito">Tarjeta de débito</option>
                        <option value="Paypal">Paypal</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Dirección: </span>
                    <input type="text" name="flat" placeholder="Ej: Avenida Castilla, 33, 9ºB" required>
                </div>
                <div class="inputBox">
                    <span>Localidad:</span>
                    <input type="text" name="location" placeholder="Ej: Usera" required>
                </div>
                <div class="inputBox">
                    <span>Ciudad:</span>
                    <input type="text" name="city" placeholder="Ej: Madrid" required>
                </div>
                <div class="inputBox">
                    <span>Código postal:</span>
                    <input type="number" min="0" name="pin_code" placeholder="Ej: 28900" required>
                </div>
            </div>
            <div class="row text-center d-block">
                <input type="submit" name="order" value="Confirmar pedido" class="btn" ">
            </div>

        </form>

    </section>

    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>

<?php
@include 'scripts/sweetalert.php';
?>