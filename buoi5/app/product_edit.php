<?php 
require_once __DIR__ . "/model/product.php";
session_start();
// Nếu chưa đăng nhập (không có biến session 'user'), đá về trang login ngay lập tức
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Không tìm thấy mã ID sản phẩm cần sửa.");
}

$id = (int)$_GET['id'];
$product = getProductById($id);

if (!$product) {
    die("Sản phẩm có ID = $id không tồn tại trong hệ thống.");
}

$errors = [];
$success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);
    if (empty($name)) {
        $errors['name'] = "Tên sản phẩm không được để rỗng.";
    }
    if ($price = "" || !is_numeric($price) || $price <=0) {
        $errors['price'] = "Giá sản phẩm phải là số và lớn hơn 0.";
    }
    if ($quantity == "" || !is_numeric($quantity) || $quantity < 0) {
        $errors['quantity'] = "Số lượng phải là số và không được nhỏ hơn 0.";
    }
    if(empty($errors)) {
        $result = updateProduct($id,$name,(float)$price,(int)$quantity);
        if ($result) {
            $success_msg = "Cập nhật sản phẩm thành công!";
            $product = getProductById($id);
            header("refresh:1.5;url=product_list.php");
        } else {
            $errors['system'] = "Cập nhật thất bại, vui lòng kiểm tra lại.";
        }
    }
}
?>

<?php include __DIR__ .'/view/header.php'; ?>
<h2>Sửa thông tin sản phẩm (ID: <?php echo $product['id']; ?>) </h2>

<?php if(!empty($success_msg)): ?>
    <div class="success"><?php echo $success_msg; ?></div>
<?php endif;?>

<form action="product_edit.php?id=<?php echo $product['id'];?>" method="POST">
    <div class="form-group">
        <label> Tên sản phẩm:</label>
        <input type="text" name="name" value="<?php echo isset($_POST['name']) ?htmlspecialchars($_POST['name']) :htmlspecialchars($product['name']); ?>">
        <?php if (isset($errors['name'])): ?>
            <div class="error"><?php echo $errors['name'];?></div>
        <?php endif;?>
    </div>

    <div class="form-group">
        <label>Giá sản phẩm:</label>
        <input type="number" name = "price" step="any" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) :htmlspecialchars($product['price']);?>">
        <?php if (isset($errors['price'])): ?>
            <div class="error"><?php echo $errors['price'];?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Số lượng:</label>
        <input type="number" name="quantity" value="<?php echo isset($_POST['quantity']) ?htmlspecialchars($_POST['quantity']) :htmlspecialchars($product['quantity']); ?>">
        <?php if (isset($errors['quantity'])):?>
            <div class="error"><?php echo $errors['quantity']; ?> </div>
        <?php endif;?>
    </div>

    <button type="submit" class = "btn btn-green"> Cập nhật sản phẩm</button>
    <a href="product_list.php" style="margin-left: 10px;">Hủy bỏ</a>
</form>

<?php include __DIR__ .'/view/footer.php';?>