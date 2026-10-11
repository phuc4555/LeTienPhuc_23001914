<?php
require_once __DIR__  . "view\\product.php";
if(!isset($_GET['id']) || empty($_GET['id'])) {
    die("Không tìm thấy mã ID sản phẩm cần sửa.");
}
$id = (int)$_GET['id'];
$product = getProductById($id);

if (!$product) {
    die("Sản phẩm có ID = $id không tồn tại trong hệ thống.");
}
$error = [];
$success_msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);

    if (empty($name)) {
        $errors['name'] = "Tên sản phẩm không được để rỗng.";
    }
    if ($price == "" || !is_numeric($price) || $price<= 0) {
        $errors['price'] = "Giá sản phẩm phải là số và lớn hơn 0.";
    }
    if ($quantity == "" || !is_numeric($quantity) || $quantity<0) {
        $errors['quantity'] = "Số lượng phải là số và không được nhỏ hơn 0.";
    }
    if (empty($errors)) {
        $result = updateProduct($id,$name,(float) $price,(int) $quantity);
        if ($result) {
            $success_msg = "Cập nhật sản phẩm thành công!";
            $product = getProductById($id);
            header("refresh:1.5;url = product_list.php");
        } else {
            $error['system'] = "Cập nhật thất bại, vui lòng kiểm tra lại.";
        }
    } 
}
require_once __DIR__ ."view\\product_edit_view.php";
?>