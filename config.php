<?php

    $conn = mysqli_connect('localhost', 'root', '', 'phoenixcomps') or die('Conexión fallida');

    mysqli_select_db($conn, 'phoenixcomps') or die('No se puede seleccionar la BD');

    if (mysqli_connect_errno()) {
        printf('<p>Conexión fallida: %s</p>', mysqli_connect_error());
        exit();
    }

    $conn->set_charset('utf8');

?>