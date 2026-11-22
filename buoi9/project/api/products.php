<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config/db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $pageParam = $_GET['page'] ?? 1;
        $limitParam = $_GET['limit'] ?? 5;

        if (filter_var($pageParam, FILTER_VALIDATE_INT) === false || $pageParam < 1) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Tham số page phải là số nguyên dương.']);
            exit;
        }
        
        if (filter_var($limitParam, FILTER_VALIDATE_INT) === false || $limitParam < 1) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Tham số limit phải là số nguyên dương.']);
            exit;
        }

        $page = (int)$pageParam;
        $limit = (int)$limitParam;

        $stmtCount = $pdo->query("SELECT COUNT(*) FROM products");
        $total = (int)$stmtCount->fetchColumn();

        $totalPages = max(1, (int)ceil($total / $limit));

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $offset = ($page - 1) * $limit;

        $stmt = $pdo->prepare("SELECT id, name, price, stock, image FROM products ORDER BY id ASC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = [
            'success' => true,
            'data' => $products,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'total_pages' => $totalPages
            ]
        ];

        $json = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
        if ($json === false) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Lỗi mã hóa JSON: ' . json_last_error_msg()]);
        } else {
            echo $json;
        }
        break;



    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $name = trim($input['name'] ?? '');
        $price = $input['price'] ?? 0;
        $stock = $input['stock'] ?? 0;

        if ($name === '' || !is_numeric($price) || $price < 0 || !is_numeric($stock) || (int)$stock < 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Dữ liệu sản phẩm (tên, giá, tồn kho) không hợp lệ.']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO products (name, price, stock) VALUES (?, ?, ?)");
        $stmt->execute([$name, $price, (int)$stock]);
        $newId = (int)$pdo->lastInsertId();

        echo json_encode([
            'success' => true,
            'message' => 'Thêm sản phẩm thành công.',
            'id' => $newId
        ]);
        break;
    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        $id = (int)($input['id'] ?? 0);
        $name = trim($input['name'] ?? '');
        $price = $input['price'] ?? 0;
        $stock = $input['stock'] ?? 0;

        if ($id <= 0 || $name === '' || !is_numeric($price) || $price < 0 || !is_numeric($stock) || (int)$stock < 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Dữ liệu cập nhật không hợp lệ.']);
            exit;
        }

        // Cập nhật thông tin chữ và số, giữ nguyên cột image
        $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ?");
        $stmt->execute([$name, $price, (int)$stock, $id]);

        echo json_encode([
            'success' => true,
            'message' => 'Cập nhật thông tin sản phẩm thành công.',
            'id' => $id
        ]);
        break;
    case 'DELETE':
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID không hợp lệ.']);
            exit;
        }

        // Xóa file ảnh vật lý nếu có
        $stmtImg = $pdo->prepare("SELECT image FROM products WHERE id = ?");
        $stmtImg->execute([$id]);
        $product = $stmtImg->fetch();

        if ($product && !empty($product['image'])) {
            $filePath = '../' . $product['image'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);

        echo json_encode([
            'success' => true,
            'message' => 'Xóa sản phẩm thành công.'
        ]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Phương thức không được hỗ trợ.']);
}







?>