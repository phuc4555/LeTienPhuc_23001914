<?php
require_once __DIR__ . "/model/product.php";

$error = [];
$success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);

    if(empty($name)) {
        $error['name'] = "Tên sản phẩm không được để rỗng.";
    }

    if ($price == "" || !is_numeric($price) || $price <=0) {
        $error['price'] = "Giá sản phẩm phải là số và lớn hơn 0.";
    }
    if ($quantity === "" || !is_numeric($quantity) || $quantity <0) {
        $error['quantity'] = "Số lượng phải là số và không được nhỏ hơn 0.";
    }
    if (empty($error)) {
        $price = (float)$price;
        $quantity = (int) $quantity;

        $result = addProduct($name,$price,$quantity);
        if ($result) {
            $success_msg = "Thêm sản phẩm thành công!";
            header("refresh:1.5;url = product_list.php");
        } else {
            $error['system'];
        }
    }
}
require_once __DIR__ . '/view/product_add_view.php';
?>