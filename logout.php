<?php

@include 'config.php';

session_start();
session_unset();
session_destroy();

if (isset($_COOKIE['user_id'])) {
   setcookie('user_id', $username, time() - 3600);
}
if (isset($_COOKIE['admin'])) {
   setcookie('admin', $admin, time() - 3600);
}

header('location:index');

?>