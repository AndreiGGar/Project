-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-06-2022 a las 08:28:01
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `phoenixcomps`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `brands`
--

INSERT INTO `brands` (`id`, `name`) VALUES
(1, 'Apple'),
(2, 'Samsung'),
(3, 'Xiaomi'),
(4, 'MSI'),
(5, 'Lenovo'),
(6, 'Asus'),
(7, 'Realme'),
(8, 'HP'),
(9, 'LG'),
(10, 'Gigabyte'),
(11, 'Acer'),
(12, 'Sony'),
(13, 'Microsoft');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Ordenador Sobremesa'),
(2, 'Ordenador Portátil'),
(3, 'Smartphone'),
(4, 'Tablet'),
(5, 'Televisor'),
(6, 'Consola');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `number` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`) VALUES
(1, 'vplayerpro@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_products` text NOT NULL,
  `total_price` double NOT NULL,
  `method` varchar(256) NOT NULL,
  `place` text NOT NULL,
  `payment_status` varchar(256) NOT NULL,
  `app_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `category` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  `image` text NOT NULL,
  `status` int(1) NOT NULL COMMENT '1--Sale/0--NotSale',
  `date_add` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `category`, `brand`, `image`, `status`, `date_add`) VALUES
(1, 'Sony PS5 Digital Edition, 825 GB, 4K, HDR, Blanco', 'Aumentamos la capacidad de almacenamiento de tu PS5 manteniendo la garantía del fabricante. Se acabó el borrar y reinstalar juegos por falta de espacio, y sin perder la garantía\r\noficial.\r\n\r\nDirecta desde el futuro y con un diseño renovado en color blanco llega la PlayStation 5 (PS5) Digital Edition*.', 399, 6, 12, 'images/ps5.png', 1, '2022-06-20 16:12:56'),
(2, 'MSI Katana GF66 12UD-081XES Intel Core i7-12700H/16GB/512GB SSD/RTX3050Ti/15.6\"', 'La victoria se mide en milisegundos\r\nNVIDIA Reflex ofrece la máxima ventaja competitiva. La latencia más baja. La mejor capacidad de respuesta con la tecnología de los portátiles con GeForce RTX serie 30. Adquiere objetivos más rápido, reacciona con más rapidez y aumenta la precisión del objetivo con un conjunto revolucionario de tecnologías para medir y optimizar la latencia del sistema para los juegos competitivos.', 1159.99, 2, 4, 'images/msi-katana-gf66-12ud-081xes-intel-core-i7-12700h-16gb-512gb-ssd-rtx3050ti-156.png', 1, '2022-06-20 16:18:24'),
(3, 'Lenovo IdeaPad Gaming 3 15ACH6 AMD Ryzen 5 5600H/16 GB/512GB SSD/RTX3050/15.6\"', 'Asciende al nivel superior de los juegos de élite con el procesador móvil excepcional AMD Ryzen™ 5000 de serie H y las últimas GPU NVIDIA® GeForce RTX™. El IdeaPad Gaming 3, que ofrece el valor máximo como un ordenador que se puede usar para todo, te permite jugar tan rápido y conducir tan duro como los profesionales, con la pantalla IPS FHD de hasta 165 Hz ultrarrápida, la tecnología N-key rollover al 100 % en tu teclado ultrarrápido, sistema de refrigeración más rápido que disipa un 40 % más de calor y un sonido envolvente a cargo de Nahimic.', 799, 2, 5, 'images/lenovo-ideapad-gaming-3-15ach6-amd-ryzen-5-5600h-16-gb-512gb-ssd-rtx3050-156.png', 1, '2022-06-20 16:20:25'),
(4, 'Samsung Galaxy Tab S8 Plus WiFi 256GB Gris Oscuro + Cargador 25W', 'Samsung Galaxy Tab S8 Plus WiFi 256GB Gris Oscuro + Cargador 25W', 999.99, 4, 2, 'images/samsung-galaxy-tab-s8-plus-wifi-256gb-gris-oscuro-cargador-25w-23b1d9cd-c990-47d6-9430-6dbeaaab85bb.png', 1, '2022-06-20 16:23:28'),
(5, 'Apple iPhone 13 Pro MAX 128GB Grafito Libre', 'Prodigioso Pro.\r\n\r\nUn sistema de cámaras revolucionario.  Una pantalla con una respuesta tan fluida que cada toque parece magia. El chip más rápido que jamás ha tenido un móvil. Una resistencia extraordinaria. Y la mayor autonomía en un iPhone.\r\n\r\nEs todo un Pro.', 1235.95, 3, 1, 'images/apple-iphone-13-pro-max-128gb-grafito-libre.png', 1, '2022-06-20 16:25:16'),
(6, 'LG 50UP75006LF 50\" LED UltraHD 4K HDR10 Pro', 'Los televisores LG UHD superan sus expectativas en todo momento. Experimente una calidad de imagen realista y colores vivos con cuatro veces más precisión de píxeles que Full HD gracias al LG 50UP75006LF.\r\n\r\nRendimiento de gran éxito garantizado\r\nLleva el cine a casa. FILMMAKER MODE ™ y HDR le brindan una experiencia de visualización más inmersiva. Conéctese con sus plataformas de transmisión favoritas para acceder al contenido que ama.', 389.98, 5, 9, 'images/lg-50up75006lf-50-led-ultrahd-4k-hdr10-pro.jpg', 1, '2022-06-20 16:27:30'),
(7, 'HP Pavilion Gaming Desktop TG01-2085ns AMD Ryzen 7 5700G/16GB/1TB+512GB SSD/RTX 3060', 'Más potencia desde el primer momento. Juega como siempre has querido. Este potente equipo está diseñado para seguir el ritmo de los juegos más actuales y de los que están por venir. Bajo su exterior compacto y elegante, encontrarás toda la potencia que necesitas para jugar a lo que quieras y el espacio necesario para incorporar mejoras.', 1099.01, 1, 8, 'images/hp-pavilion-gaming-desktop-tg01-2085ns-amd-ryzen-7-5700g-16gb-1tb-512gb-ssd-rtx-3060.png', 1, '2022-06-20 16:29:21'),
(8, 'Xiaomi Mi TV P1 50\" LED UltraHD 4K HDR10+', 'Vida inteligente, visión ilimitada. Los nuevos televisores Xiaomi Mi TV P1 vienen en una variedad de opciones de tamaño de pantalla que van desde 55\", 50\", 43\", hasta un estándar de 32\".\r\n\r\nMi TV P1 Series es la última oferta de TV de Xiaomi que hace el entretenimiento doméstico inteligente más accesible para todos. Este televisor asegura una calidad de imagen de primera clase con resolución 4K, Dolby Vision, compatibilidad con HDR10+ y MEMC.\r\n\r\nToda la serie cuenta con una visualización épica con su elegante diseño sin bisel, un Android TV fácil de usar, sistema con Asistente de Google integrado, así como estéreo nítido con altavoces compatibles con Dolby Audio y DTS-HD.', 299.98, 5, 3, 'images/xiaomi-mi-tv-p1-50-led-ultrahd-4k-hdr10.png', 1, '2022-06-20 16:31:50'),
(9, 'Asus ROG Strix SCAR 17 G733ZS-LL012W Intel Core i9-12900H/32GB/1TB SSD/RTX 3080/17.3\"', 'Con la potencia bruta del nuevo ROG Strix SCAR 17 de 2022 y Windows 11 Pro podrás competir con más fotogramas. Enfréntate a cualquier enemigo con una CPU Intel® Core™ i9-12900H emparejada con una GPU NVIDIA® GeForce RTX™ para portátiles con un TGP máximo de 150 W. Olvida las esperas y pantallas de carga con el almacenamiento de estado sólido PCIe Gen. 4 y deja a la competencia mordiendo el polvo con el ancho de banda de la memoria DDR5.', 3299, 2, 6, 'images/asus-rog-strix-scar-17-g733zs-ll012w-intel-core-i9-12900h-32gb-1tb-ssd-rtx-3080-173.png', 1, '2022-06-20 16:33:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user-type`
--

CREATE TABLE `user-type` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user-type`
--

INSERT INTO `user-type` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `token` varchar(256) NOT NULL,
  `status` int(1) NOT NULL,
  `user_type` int(11) NOT NULL,
  `date_add` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `token`, `status`, `user_type`, `date_add`) VALUES
(1, 'Andrei', 'vplayerpro@gmail.com', '68e6ed08868122944bdfd03288ecbcec', 'caa974331748cf5c4fac2b6e155f1ca9', 1, 1, '2022-06-20 12:44:17'),
(2, 'Andrei', 'vplayerpro@hotmail.com', '2c08e574dddde7780aa5336bcbb84898', 'ee8ddd7c253060adf54c07b8647a26aa', 1, 2, '2022-06-20 16:38:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand` (`brand`),
  ADD KEY `category` (`category`);

--
-- Indices de la tabla `user-type`
--
ALTER TABLE `user-type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_type` (`user_type`);

--
-- Indices de la tabla `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `user-type`
--
ALTER TABLE `user-type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_type`) REFERENCES `user-type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
