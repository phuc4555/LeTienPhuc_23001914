<?php
require_once __DIR__ . "/model/product.php";
session_start();
// Nếu chưa đăng nhập (không có biến session 'user'), đá về trang login ngay lập tức
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$errors = [];
$success_msg = "";
if ($_SERVER["REQUEST_METHOD"] ==  "POST") {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);

    if (empty($name)) {
        $errors['name'] = "Tên sản phẩm không được để rỗng.";
    }
    if ($price == "" || !is_numeric($price) || $price <=0) {
        $errors['price'] = "Giá sản phẩm phải là số và lớn hơn 0.";
    }
    if ($quantity == "" || !is_numeric($quantity) || $quantity < 0) {
        $errors['quantity'] = "Số lượng phải là số và không được nhỏ hơn 0.";
    }
    if (empty($errors)) {
        $price  = (float) $price;
        $quantity = (int) $quantity;
        $result = addProduct($name,$price,$quantity) ;
        if ($result) {
            $success_msg = "Thêm sản phẩm thành công!";
            header("refresh:1.5;url=product_list.php");
        } else {
            $errors['system'] = "Lỗi hệ thống, vui lòng thử lại sau.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset = "UTF-8">
    <title> Thêm sản phẩm mới</title>
    <style>
        body{font-family:Arial,sans-serif;margin:30px;}
        .form-group{margin-bottom: 15px;width: 300px;}
        label {display: block;font-weight: bold;margin-bottom:5px;}
        input[type = "text"],input[type = "number"],textarea{width;100%;padding:8px;box-sizing:border-box;}
        .error{color:red;font-size:13px;margin-top:5px}
        .success{color:green;font-weight:bold;margin-bottom:15px;}
        .btn-submit{background-color:#28a745;color:white;padding:10px 15px;border:none;border-radius: 4px;cursor:pointer;}
        .btn-back{color:#007bff;text-decoration: none;margin-left: 10px;}
    </style>
</head>
<body>
    <h2>Thêm sản phẩm mới</h2>
    <?php if(!empty($success_msg)): ?>
        <div class="success"><?php echo $success_msg;?></div>
    <?php endif;?>

    <?php if(isset($errors['system'])): ?>
        <div class="error"><?php echo $errors['system']; ?></div>
    <?php endif; ?>
    <form action="product_add.php" method = "POST">
        <div class="form-group">
            <label>Tên sản phẩm:</label>
            <input type="text" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name'] ) : ''; ?>">

            <?php if (isset($errors['name'])) :?>
                <div class="error"><?php echo $errors['name']; ?> </div>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label>Giá sản phẩm (VND):</label>
            <input type="number" name="price" step="any" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>">
            <?php if (isset($errors['price'])): ?>
                <div class="error"><?php echo $errors['price']; ?></div>
            <?php endif;?>
        </div>
        
        <div class="form-group">
            <label>Số lượng:</label>
            <input type="number" name="quantity" value="<?php echo isset($_POST['quantity']) ?htmlspecialchars($_POST['quantity']) : ''; ?>">
            <?php if (isset($errors['quantity'])): ?>
                <div class="error"><?php echo $errors['quantity']; ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn-submit">Lưu sản phẩm</button>
        <a href="product_list.php" class="btn-back">Quay lại danh sách</a>
    </form>
</body>
</html>
        