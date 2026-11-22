<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Chỉ chấp nhận phương thức POST.']);
    exit;
}

// 1. Kiểm tra mã sản phẩm
$productId = filter_var($_POST['product_id'] ?? null, FILTER_VALIDATE_INT);
if ($productId === false || $productId <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Mã sản phẩm không hợp lệ.']);
    exit;
}

// Kiểm tra sản phẩm có tồn tại trong CSDL không
$stmt = $pdo->prepare("SELECT id, image FROM products WHERE id = ?");
$stmt->execute([$productId]);
$product = $stmt->fetch();

if (!$product) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
    exit;
}

// 2. Kiểm tra file được gửi lên
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Không nhận được file hoặc quá trình tải lên bị gián đoạn.']);
    exit;
}

$file = $_FILES['image'];

// 3. Kiểm tra dung lượng thực tế tối đa 2MB (2 * 1024 * 1024 bytes)
$maxSize = 2 * 1024 * 1024;
if ($file['size'] > $maxSize) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Dung lượng ảnh vượt quá giới hạn 2 MB.']);
    exit;
}

// 4. Kiểm tra loại ảnh thực tế bằng MIME Type (chỉ nhận JPG, JPEG, PNG)
$finfo = new finfo(FILEINFO_MIME_TYPE);
$realMimeType = $finfo->file($file['tmp_name']);
$allowedMimes = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png'
];

if (!array_key_exists($realMimeType, $allowedMimes)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Định dạng ảnh thực tế không hợp lệ. Chỉ chấp nhận JPG, JPEG hoặc PNG.']);
    exit;
}

// 5. Tạo thư mục uploads nếu chưa tồn tại và tạo tên file duy nhất
$uploadDir = '../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$extension = $allowedMimes[$realMimeType];
$uniqueFileName = 'prod_' . $productId . '_' . uniqid('', true) . '.' . $extension;
$destination = $uploadDir . $uniqueFileName;
$dbImagePath = 'uploads/' . $uniqueFileName;

// 6. Di chuyển file và cập nhật CSDL
if (move_uploaded_file($file['tmp_name'], $destination)) {
    // Xóa file ảnh cũ trên ổ đĩa nếu có
    if (!empty($product['image']) && file_exists('../' . $product['image'])) {
        unlink('../' . $product['image']);
    }

    $updateStmt = $pdo->prepare("UPDATE products SET image = ? WHERE id = ?");
    $updateStmt->execute([$dbImagePath, $productId]);

    echo json_encode([
        'success' => true,
        'message' => 'Upload ảnh thành công.',
        'image' => $dbImagePath
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Không thể lưu file vào máy chủ. Vui lòng thử lại.']);
}

?>