<?php 
require_once __DIR__ .'/model/product.php';
session_start();
// Nếu chưa đăng nhập (không có biến session 'user'), đá về trang login ngay lập tức
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$products = getAllProducts();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <style>
        body {font-family: Arial, sans-serif;margin:30px;}
        table {width: 100%; border-collapse:collapse;margin-top:20px;}
        th,td {border:1px solid #ddd;padding :12px;text-align:left;}
        th {background-color: #f2f2f2;}
        th:hover {background-color: #f5f5f5}
        .btn {padding: 6px 12px; text-decoration:none;border-radius:4px;color: white;display:inline-block;}
        .btn-add{ background-color: #28a745; margin-bottom:20px;}
        .btn-edit{ background: #007bff; margin-right: 5px;}
        .btn-delete{background-color: #dc3545};
    </style>
</head>
<body>
    <?php if (isset($_SESSION['user'])): ?>
    <div style="background: #f8f9fa; padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">
        Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['username']) ?></strong> | 
        <a href="logout.php" style="color: red; text-decoration: none; font-weight: bold;" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')">Đăng xuất</a>
    </div>
    <?php endif; ?>

    <h2> Quản lý Danh sách Sản phẩm</h2>
    <a href="product_add.php" class="btn btn-add">+Thêm sản phẩm mới</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá (VND)</th>
                <th>Số lượng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $row): ?>
                    <tr>
                        <td><?php echo $row['id']; ?> </td>
                        <td><strong><?php echo htmlspecialchars($row['name']);?></strong></td>
                        <td><?php echo number_format($row['price']); ?> đ </td>
                        <td><?php echo $row['quantity']; ?> </td>
                        
                        <td>
                            <a href="product_edit.php?id=<?php echo $row['id']; ?>"class= "btn btn-edit">Sửa</a>
                            <a href="product_delete.php?id=<?php echo $row['id']; ?>"
                                class="btn btn-delete"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;color: #888;">Chưa có sản phẩm nào trong hệ thống.</td>
                </tr>
            <?php endif;?>
        </tbody>
    </table>
</body>
</html>




