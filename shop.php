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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="src/logo.ico">
    <title>Catálogo</title>
    <!-- bootstrap link  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">

    <!-- font awesome link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- sweetalert link  -->
    <script src="js/sweetalert2.all.min.js"></script>

    <!-- jquery link  -->
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css">

    <!-- css link  -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php @include 'header.php'; ?>

    <section class="heading">
        <h3>nuestra tienda</h3>
        <p> <a href="index">Inicio</a> / Catálogo </p>
    </section>

    <section class="products">

        <div class="row">

            <div class="col-sm-3">

                <h1 class="title text-left">Filtro</h1>
                <div class="list-group">
                    <h3>Precio</h3>
                    <input type="hidden" id="hidden_minimum_price" value="0">
                    <input type="hidden" id="hidden_maximum_price" value="10000">
                    <p id="price_show">0€ - 5000€</p>
                    <div id="price_range"></div>
                </div>
                <div class="list-group">
                    <h3>Marca</h3>
                    <div class="brand">
                        <?php

                        $query = "SELECT DISTINCT name FROM brands";
                        $result = mysqli_query($conn, $query) or die('query failed');
                        foreach ($result as $row) {
                        ?>
                            <div class="list-group-item checkbox">
                                <label><input type="checkbox" class="common_selector brand" value="<?php echo $row['name']; ?>"> <?php echo $row['name']; ?></label>
                            </div>
                        <?php
                        }

                        ?>
                    </div>
                </div>
                <div class="list-group">
                    <h3>Categoría</h3>
                    <div class="category">
                        <?php

                        $query = "SELECT DISTINCT name FROM categories";
                        $result = mysqli_query($conn, $query) or die('query failed');
                        foreach ($result as $row) {
                        ?>
                            <div class="list-group-item checkbox">
                                <label><input type="checkbox" class="common_selector category" value="<?php echo $row['name']; ?>"> <?php echo $row['name']; ?></label>
                            </div>
                        <?php
                        }

                        ?>
                    </div>
                </div>
            </div>


            <div class="col-sm-9">

                <h1 class="title">Productos</h1>

                <div class="box-container">

                    <!-- <?php
                            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                            if (mysqli_num_rows($select_products) > 0) {
                                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                            ?>
                            <form action="" method="POST" class="box">
                                <a href="view_page?pid=<?php echo $fetch_products['id']; ?>" class="fas fa-eye"></a>
                                <div class="price"><?php echo $fetch_products['price']; ?>€</div>
                                <img src="<?php echo $fetch_products['image']; ?>" alt="" class="image">
                                <div class="name"><?php echo $fetch_products['name']; ?></div>
                                <input type="number" name="product_quantity" value="1" min="0" class="qty">
                                <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                                <input type="submit" value="Añadir a Deseados" name="add_to_wishlist" class="option-btn">
                                <input type="submit" value="Añadir al Carrito" name="add_to_cart" class="btn">
                            </form>
                    <?php
                                }
                            } else {
                                echo '<p class="empty">¡No hay productos!</p>';
                            }
                    ?> -->

                </div>

            </div>

        </div>

    </section>

    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>

    <script>
        $(document).ready(function() {

            filter_data();

            function filter_data() {
                // $('.shop_filter').html('<div id="loading" style="" ></div>');
                var action = 'shop_filter';
                var minimum_price = $('#hidden_minimum_price').val();
                var maximum_price = $('#hidden_maximum_price').val();
                var brand = get_filter('brand');
                var category = get_filter('category');
                $.ajax({
                    url: "shop_filter",
                    method: "POST",
                    data: {
                        action: action,
                        minimum_price: minimum_price,
                        maximum_price: maximum_price,
                        brand: brand,
                        category: category
                    },
                    success: function(data) {
                        $('.products .box-container').html(data);
                    }
                });
            }

            function get_filter(class_name) {
                var filter = [];
                $('.' + class_name + ':checked').each(function() {
                    filter.push($(this).val());
                });
                return filter;
            }

            $('.common_selector').click(function() {
                filter_data();
            });

            $('#price_range').slider({
                range: true,
                min: 0,
                max: 5000,
                values: [0, 5000],
                step: 100,
                stop: function(event, ui) {
                    $('#price_show').html(ui.values[0] + '€ - ' + ui.values[1] + '€');
                    $('#hidden_minimum_price').val(ui.values[0]);
                    $('#hidden_maximum_price').val(ui.values[1]);
                    filter_data();
                }
            });

        });
    </script>

</body>

</html>

<?php
@include 'scripts/sweetalert.php';
?>