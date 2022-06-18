<?php

@include 'config.php';

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        if (isset($_GET['pid'])) {
            $pid = $_GET['pid'];
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$pid'") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>
                    <form action="" method="POST">
                        <img src="<?php echo $fetch_products['image']; ?>" alt="" class="image">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <div class="price"><?php echo $fetch_products['price']; ?>€</div>
                        <div class="details"><?php echo $fetch_products['description']; ?></div>
                        <input type="number" name="product_quantity" value="1" min="0" class="qty">
                        <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                        <div class="row d-flex justify-content-center">
                            <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn">
                        </div>
                        <div class="row d-flex justify-content-center">
                            <input type="submit" value="add to cart" name="add_to_cart" class="btn">
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