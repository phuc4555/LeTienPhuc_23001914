<?php
// Bắt buộc phải có session_start() ở đầu file khi làm việc với Session
session_start();
require_once __DIR__ . "/model/product.php";

// Nếu đã đăng nhập rồi thì tự động vào thẳng danh sách sản phẩm
if (isset($_SESSION['user'])) {
    header("Location: product_list.php");
    exit;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username)) {
        $errors['username'] = "Vui lòng nhập tên đăng nhập.";
    }
    if (empty($password)) {
        $errors['password'] = "Vui lòng nhập mật khẩu.";
    }

    if (empty($errors)) {
        $user = getUserByUsername($username);
        
        // Sử dụng password_verify để kiểm tra mật khẩu đã mã hóa
        if ($user && password_verify($password, $user['password'])) {
            // Đăng nhập thành công -> lưu thông tin vào SESSION
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username']
            ];
            header("Location: product_list.php");
            exit;
        } else {
            $errors['login'] = "Tên đăng nhập hoặc mật khẩu không chính xác.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .form-group { margin-bottom: 15px; width: 300px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; box-sizing: border-box; }
        .error { color: red; font-size: 13px; margin-top: 5px; }
        .btn { background-color: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Đăng nhập hệ thống</h2>
    <?php if (isset($errors['login'])): ?><div class="error" style="margin-bottom:15px; font-weight:bold;"><?= $errors['login'] ?></div><?php endif; ?>

    <form action="login.php" method="POST">
        <div class="form-group">
            <label>Tên đăng nhập:</label>
            <input type="text" name="username" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
            <?php if (isset($errors['username'])): ?><div class="error"><?= $errors['username'] ?></div><?php endif; ?>
        </div>
        <div class="form-group">
            <label>Mật khẩu:</label>
            <input type="password" name="password">
            <?php if (isset($errors['password'])): ?><div class="error"><?= $errors['password'] ?></div><?php endif; ?>
        </div>
        <button type="submit" class="btn">Đăng nhập</button>
        <p>Chưa có tài khoản? <a href="register.php">Đăng ký tại đây</a></p>
    </form>
</body>
</html>
