<?php

//fetch_data.php

include('config.php');

if (isset($_POST["action"])) {
	$query = "
	SELECT *, a.id as id, a.name as name, b.name as brandname, c.name as categoryname FROM `products` as A INNER JOIN `brands` as b INNER JOIN `categories` as c WHERE a.brand = b.id AND a.category = c.id AND a.status = 1
	";
	if (isset($_POST["maximum_price"]) && !empty($_POST["maximum_price"])) {
		$query .= "
			AND a.price BETWEEN '0' AND '" . $_POST["maximum_price"] . "'
		";
	}
	if (isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"])) {
		$query .= "
			AND a.price BETWEEN '" . $_POST["minimum_price"] . "' AND '" . $_POST["maximum_price"] . "'
		";
	}
	if (isset($_POST["brand"])) {
		$brand_filter = implode("','", $_POST["brand"]);
		$query .= "
			AND b.name IN('" . $brand_filter . "')
		";
	}
	if (isset($_POST["category"])) {
		$category_filter = implode("','", $_POST["category"]);
		$query .= "
		 AND c.name IN('" . $category_filter . "')
		";
	}
	$total_row = mysqli_query($conn, $query) or die('query failed');
	$output = '';
	if (mysqli_num_rows($total_row) > 0) {
		foreach ($total_row as $row) {
			$output .= '

				<form action="" method="POST" class="box">
					<a href="view_page.php?id=' . $row['id'] . '" class="fas fa-eye"></a>
					<div class="price">' . number_format($row["price"], 2, ',', '.') . '€</div>
					<img src="' . $row['image'] . '" alt="" class="image">
					<div class="name">' . $row['name'] . '</div>
					<input type="number" name="product_quantity" value="1" min="0" class="qty">
					<input type="hidden" name="product_id" value="' . $row['id'] . '">
					<input type="hidden" name="product_name" value="' . $row['name'] . '">
					<input type="hidden" name="product_price" value="' . $row['price'] . '">
					<input type="hidden" name="product_image" value="' . $row['image'] . '">
					<input type="submit" value="Añadir a Deseados" name="add_to_wishlist" class="option-btn">
					<input type="submit" value="Añadir al Carrito" name="add_to_cart" class="btn">
				</form>
				
			';
		}
	} else {
		$output = '<h2 class="secondary" id="secondary_text">No se encuentran productos con las especificaciones indicadas</h2>';
	}
	echo $output;
}
