<?php
require_once __DIR__ . "/model/product.php";
$errors = [];
$success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username)) {
        $errors['username'] = "Tên đăng nhập không được để trống.";
    }
    if (empty($password)) {
        $errors['password'] = "Mật khẩu không được để trống.";
    }

    if (empty($errors)) {
        if (checkUsernameExists($username)) {
            $errors['username'] = "Tên đăng nhập này đã tồn tại.";
        } else {
            if (registerUser($username, $password)) {
                $success_msg = "Đăng ký thành công! Đang chuyển đến trang đăng nhập...";
                header("refresh:2;url=login.php");
            } else {
                $errors['system'] = "Lỗi hệ thống, vui lòng thử lại sau.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .form-group { margin-bottom: 15px; width: 300px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; box-sizing: border-box; }
        .error { color: red; font-size: 13px; margin-top: 5px; }
        .success { color: green; font-weight: bold; margin-bottom: 15px; }
        .btn { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Đăng ký tài khoản</h2>
    <?php if (!empty($success_msg)): ?><div class="success"><?= $success_msg ?></div><?php endif; ?>
    <?php if (isset($errors['system'])): ?><div class="error"><?= $errors['system'] ?></div><?php endif; ?>

    <form action="register.php" method="POST">
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
        <button type="submit" class="btn">Đăng ký</button>
        <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
    </form>
</body>
</html>
