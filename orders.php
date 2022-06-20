<?php

@include 'config.php';

session_start();

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION['user_id'];
}
if (isset($_COOKIE["user_id"])) {
    $user_id = $_COOKIE['user_id'];
}

if(!isset($user_id)){
   header('location:login');
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
   <title>Pedidos</title>
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
    <h3>Pedidos</h3>
    <p> <a href="home">Inicio</a> / pedido </p>
</section>

<section class="placed-orders">

    <h1 class="title">Pedidos realizados</h1>

    <div class="box-container">

    <?php
        $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_orders) > 0){
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){
    ?>
    <div class="box">
        <form action="generate_pdf" method="post" target="_blank">
        <p> Fecha pedido: <span><?php echo $fetch_orders['app_date']; ?></span> </p>
        <p> Email: <span><?php echo $user ?></span> </p>
        <p> Dirección: <span><?php echo $fetch_orders['place']; ?></span> </p>
        <p> Método de pago: <span><?php echo $fetch_orders['method']; ?></span> </p>
        <p> Tus órdenes: <span><?php echo $fetch_orders['total_products']; ?></span> </p>
        <p> Precio total: <span><?php echo number_format($fetch_orders['total_price'], 2, ',', '.'); ?>€</span> </p>
        <p> Estado de pago: <span style="color:<?php if($fetch_orders['payment_status'] == 'pendiente'){echo 'tomato'; } else {echo 'green';} ?>"><?php echo $fetch_orders['payment_status']; ?></span> </p>
        <input type="hidden" value="<?php echo $fetch_orders['id']; ?>" name="order_id">
		<button class="btn btn-success">Export</button>
        </form>
    </div>
    <?php
        }
    }else{
        echo '<p class="empty">Sin pedidos realizados todavía.</p>';
    }
    ?>
    </div>

</section>

<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>