<?php
// 1. Đã sửa: Thêm dấu gạch chéo / trước chữ model để không bị dính liền đường dẫn
require_once __DIR__ . '/model/product.php';

// 2. Đã sửa: Thêm dấu gạch chéo / trước chữ view để sửa lỗi sập giao diện header
include __DIR__ . '/view/header.php';

// 3. Kiểm tra ID sản phẩm nhận từ nút Xóa trên URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<h3> Lỗi: Không tìm thấy mã sản phẩm cần xóa! </h3>";
    echo "<a href='product_list.php' class='btn btn-blue'>Quay lại danh sách</a>";
    include __DIR__ . '/view/footer.php';
    exit;
}

$id = (int) $_GET['id'];

$product = getProductById($id);

if (!$product) {
    echo "<h3>Lỗi hành động: Sản phẩm có ID = $id không tồn tại hoặc đã bị xóa trước đó!</h3>";
    echo "<a href='product_list.php' class='btn btn-blue'>Quay lại danh sách</a>";
} else {
    // 4. Đã sửa: Gọi đúng tên hàm deleteProductById (Chữ d viết thường cuối cùng cho khớp với file model/product.php)
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

// 5. Đã sửa: Thêm dấu gạch chéo / trước chữ view cho file footer
include __DIR__ . '/view/footer.php';
?>
