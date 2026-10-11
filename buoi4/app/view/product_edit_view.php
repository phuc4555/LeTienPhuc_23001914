<?php include __DIR__ . '/header.php'; ?>

<h2>Sửa thông tin sản phẩm (ID: <?php echo $product['id']; ?>)</h2>

<?php if (!empty($success_msg)): ?>
    <div class="success"><?php echo $success_msg; ?></div>
<?php endif; ?>

<form action="product_edit.php?id=<?php echo $product['id']; ?>" method="POST">
    <div class="form-group">
        <label>Tên sản phẩm:</label>
        <input type="text" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : htmlspecialchars($product['name']); ?>">
        <?php if (isset($errors['name'])): ?>
            <div class="error"><?php echo $errors['name']; ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Giá sản phẩm:</label>
        <input type="number" name="price" step="any" value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : htmlspecialchars($product['price']); ?>">
        <?php if (isset($errors['price'])): ?>
            <div class="error"><?php echo $errors['price']; ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Số lượng:</label>
        <input type="number" name="quantity" value="<?php echo isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : htmlspecialchars($product['quantity']); ?>">
        <?php if (isset($errors['quantity'])): ?>
            <div class="error"><?php echo $errors['quantity']; ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Mô tả sản phẩm:</label>
        <textarea name="description" rows="3"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : htmlspecialchars($product['description']); ?></textarea>
    </div>

    <button type="submit" class="btn btn-green">Cập nhật sản phẩm</button>
    <a href="product_list.php" style="margin-left: 10px;">Hủy bỏ</a>
</form>

<?php include __DIR__ . '/footer.php'; ?>
