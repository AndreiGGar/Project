<?php

@include 'config.php';

session_start();

if (isset($_POST['send'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $select_message = mysqli_query($conn, "SELECT * FROM `messages` WHERE name = '$name' AND email = '$email' AND number = '$number' AND description = '$msg'") or die('query failed');

    if (mysqli_num_rows($select_message) > 0) {
        $message[] = 'message sent already!';
    } else {
        mysqli_query($conn, "INSERT INTO `messages`(name, email, number, description) VALUES('$name', '$email', '$number', '$msg')") or die('query failed');
        $message[] = 'message sent successfully!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
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
        <h3>contáctanos</h3>
        <p> <a href="index.php">Inicio</a> / Contacto </p>
    </section>

    <section class="contact">

        <form action="" method="POST">
            <h3>¡Envíanos un mensaje!</h3>
            <input type="text" name="name" placeholder="Introduce tu nombre" class="box" required>
            <input type="email" name="email" placeholder="Introduce tu email" class="box" required>
            <input type="number" name="number" placeholder="Introduce tu número de teléfono" class="box" required>
            <textarea name="message" class="box" placeholder="Introduce el mensaje" required cols="30" rows="10"></textarea>
            <input type="submit" value="send message" name="send" class="btn">
        </form>

    </section>

    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>