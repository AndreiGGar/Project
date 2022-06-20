<header class="header">

    <div class="flex">

        <a href="index" class="logo"><img src="src/logo.png" style="width:2em"><p>PhoenixComps</p></a>

        <nav class="navbar">
            <ul>
                <li><a href="index">Inicio</a></li>
                <li><a href="shop">Catálogo</a></li>
                <li><a href="about">Sobre nosotros</a></li>
                <li><a href="contact">Contacto</a></li>
                <!-- <li><a href="#">Cuenta +</a>
                    <ul>
                        <li><a href="login">Iniciar sesión</a></li>
                        <li><a href="register">Registarse</a></li>
                    </ul>
                </li> -->
            </ul>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search" class="fas fa-search"></a>
            <a href="login" id="user-btn" class="fas fa-user"></a>
            <?php
                $select_wishlist_count = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
                $wishlist_num_rows = mysqli_num_rows($select_wishlist_count);
            ?>
            <a href="wishlist"><i class="fas fa-heart"></i>(<?php echo $wishlist_num_rows; ?>)</span></a>
            <?php
                $select_cart_count = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                $cart_num_rows = mysqli_num_rows($select_cart_count);
            ?>
            <a href="cart"><i class="fas fa-shopping-cart"></i><span>(<?php echo $cart_num_rows; ?>)</span></a>
            <a href="logout" class="fas fa-door-open"></a>
        </div>

    </div>

</header>