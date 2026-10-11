<?php
require_once __DIR__ ."/model/product.php";
include __DIR__ . "view\\header.php";
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<h3> Lỗi: Không tìm thấy mã sản phẩm cần xóa! </h3>";
    echo "<a href = 'product_list.php'class = 'btn btn-blue'>Quay lại danh sách</a>";
    include __DIR__ . "view\\footer.php";
    exit;
}

$id = (int) $_GET['id'];

$product = getProductByID($id);

if (!$product) {
    echo "<h3>Lỗi hành động: Sản phẩm có ID = $id không tồn tại hoặc đã bị xóa trước đó!</h3>";
    echo "<a href='product_list.php' class='btn btn-blue'>Quay lại danh sách</a>";
}else {
    $result = deleteProductById($id);
    if ($result) {
      echo "<div class='success'>Đã xóa thành công sản phẩm: <strong>" . htmlspecialchars($product['name']) . "</strong>!</div>";
        echo "<p>Hệ thống đang tự động quay về trang danh sách sản phẩm...</p>";
        header("refresh:2; url=product_list.php");  
    } else {
        echo "<h3>Đã xảy ra lỗi hệ thống, không thể xóa sản phẩm này.</h3>";
        echo "<a href='product_list.php' class='btn btn-blue'>Quay lại danh sách</a>";
    }
}

include __DIR__ . "/view/footer.php";
?>