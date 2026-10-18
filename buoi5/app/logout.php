<?php
session_start();
// Xóa toàn bộ dữ liệu phiên đăng nhập
session_unset();
session_destroy();

// Chuyển người dùng về trang login
header("Location: login.php");
exit;
?>
