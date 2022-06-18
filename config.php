<?php

    $conn = mysqli_connect('localhost', 'root', '', 'phoenixcomps') or die('Conexión fallida');

    mysqli_select_db($conn, 'phoenixcomps') or die('No se puede seleccionar la BD');

    if (mysqli_connect_errno()) {
        printf('<p>Conexión fallida: %s</p>', mysqli_connect_error());
        exit();
    }

    $conn->set_charset('utf8');

    $base_url = "http://localhost/Project/";
    $my_email = "andrei@phoenixcomps.es";

    $smtp['host'] = "smtp.hostinger.com";
    $smtp['user'] = "andrei@phoenixcomps.es";
    $smtp['pass'] = "Aa12345678!";
    $smtp['port'] = 465;

?>