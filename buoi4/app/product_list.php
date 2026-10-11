<?php
require_once __DIR__ . '/model/product.php';

$products = getAllProducts();

require_once __DIR__ . "/view/product_list_view.php";

?>